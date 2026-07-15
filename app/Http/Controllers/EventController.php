<?php
//manage events by manager and admin users
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\EventCategory;
use App\Models\EventTag;
use App\Models\EventReminder;
use App\Notifications\EventCreatedNotification;
use App\Notifications\EventStatusChangedNotification;
use App\Services\EventActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('manage_events', Event::class);
        
        $query = Event::with('creator', 'category', 'tags');
        
        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filter by date range
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $dateFrom = $request->filled('date_from') ? $request->date_from : now()->subMonths(12)->toDateString();
            $dateTo = $request->filled('date_to') ? $request->date_to : now()->addMonths(12)->toDateString();
            $query->byDateRange($dateFrom, $dateTo);
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'event_date');
        $order = $request->get('order', 'asc');
        
        if (in_array($sortBy, ['event_date', 'created_at', 'title', 'status'])) {
            $query->orderBy($sortBy, $order);
        }
        
        $events = $query->latest('updated_at')->paginate(20);
        $statuses = [
            'draft' => 'Draft',
            'published' => 'Published',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
        ];
        $categories = EventCategory::active()->get();
        
        return view('auth.events.index', compact('events', 'statuses', 'categories'));
    }

    public function create()
    {
        $this->authorize('manage_events', Event::class);
        
        $categories = EventCategory::active()->get();
        $allTags = EventTag::orderBy('name')->get();
        
        return view('auth.events.create', compact('categories', 'allTags'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage_events', Event::class);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date|after_or_equal:today',
            'event_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable|exists:event_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:event_tags,id',
            'status' => 'required|in:draft,published'
        ]);

        $eventData = [
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'is_published' => $request->status === 'published',
            'created_by' => Auth::id()
        ];

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $this->handleFeaturedImageUpload($request->file('featured_image'));
            $eventData['featured_image'] = $imagePath;
        }

        $event = Event::create($eventData);

        // Attach tags
        if ($request->has('tags') && !empty($request->tags)) {
            $event->tags()->attach($request->tags);
        }

        // Create default reminders for published events
        if ($event->status === 'published') {
            $this->createDefaultReminders($event);
        }

        // Log activity
        EventActivityService::logEventCreated($event);

        // Send notification to all admins and managers
        $adminsAndManagers = User::whereIn('role', ['admin', 'manager'])->get();
        Notification::send($adminsAndManagers, new EventCreatedNotification($event));

        return redirect()->route('auth.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        
        $categories = EventCategory::active()->get();
        $allTags = EventTag::orderBy('name')->get();
        // Use fully-qualified column to avoid ambiguous `id` when joining pivot
        $selectedTags = $event->tags()->pluck('event_tags.id')->toArray();
        
        return view('auth.events.edit', compact('event', 'categories', 'allTags', 'selectedTags'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'nullable|exists:event_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:event_tags,id',
            'status' => 'required|in:draft,published,cancelled,completed'
        ]);

        $oldStatus = $event->status;
        $changes = [];
        
        // Track changes for logging
        if ($event->title !== $request->title) $changes['title'] = true;
        if ($event->description !== $request->description) $changes['description'] = true;
        if ($event->event_date->toDateString() !== $request->event_date) $changes['event_date'] = true;
        if ($event->location !== $request->location) $changes['location'] = true;
        if ($event->category_id !== $request->category_id) $changes['category'] = true;

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'is_published' => $request->status === 'published',
            'updated_by' => Auth::id()
        ];

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($event->featured_image) {
                $this->deleteFeaturedImage($event->featured_image);
            }
            
            $imagePath = $this->handleFeaturedImageUpload($request->file('featured_image'));
            $updateData['featured_image'] = $imagePath;
            $changes['featured_image'] = true;
        }

        $event->update($updateData);

        // Sync tags
        if ($request->has('tags')) {
            $event->tags()->sync($request->tags ?? []);
        }

        // Log activity
        EventActivityService::logEventUpdated($event, $changes);

        // Send notification if status changed
        if ($oldStatus !== $request->status) {
            EventActivityService::logStatusChanged($event, $oldStatus, $request->status);
            $adminsAndManagers = User::whereIn('role', ['admin', 'manager'])->get();
            Notification::send($adminsAndManagers, new EventStatusChangedNotification($event, $oldStatus, $request->status));
        }

        return redirect()->route('auth.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Request $request, Event $event)
    {
        $this->authorize('delete', $event);

        EventActivityService::logEventDeleted($event);
        $event->delete();

        // If the request expects JSON (AJAX/fetch), return JSON instead of redirecting
        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true, 'message' => 'Event deleted successfully.']);
        }

        return redirect()->route('auth.events.index')->with('success', 'Event deleted successfully.');
    }

    // Bulk actions
    public function bulkUpdate(Request $request)
    {
        $this->authorize('manage_events', Event::class);
        
        $request->validate([
            'event_ids' => 'required|array',
            'event_ids.*' => 'integer|exists:events,id',
            'action' => 'required|in:publish,draft,cancel,delete'
        ]);

        $eventIds = $request->event_ids;
        $action = $request->action;

        try {
            $events = Event::whereIn('id', $eventIds)->get();

            foreach ($events as $event) {
                // Check authorization for each event
                $this->authorize('update', $event);

                switch ($action) {
                    case 'publish':
                        $event->update([
                            'status' => Event::STATUS_PUBLISHED,
                            'is_published' => true,
                            'updated_by' => Auth::id()
                        ]);
                        break;
                    case 'draft':
                        $event->update([
                            'status' => Event::STATUS_DRAFT,
                            'is_published' => false,
                            'updated_by' => Auth::id()
                        ]);
                        break;
                    case 'cancel':
                        $event->update([
                            'status' => Event::STATUS_CANCELLED,
                            'is_published' => false,
                            'updated_by' => Auth::id()
                        ]);
                        break;
                    case 'delete':
                        $event->delete();
                        break;
                }
            }

            $count = count($eventIds);
            $message = match($action) {
                'publish' => "Published $count event(s) successfully.",
                'draft' => "Moved $count event(s) to draft successfully.",
                'cancel' => "Cancelled $count event(s) successfully.",
                'delete' => "Deleted $count event(s) successfully.",
                default => "Updated $count event(s) successfully."
            };

            return redirect()->route('auth.events.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('auth.events.index')->with('error', 'An error occurred while processing bulk actions.');
        }
    }

    /**
     * Display published events for the public
     */
    public function publicIndex(Request $request)
    {
        $query = Event::with('category', 'tags')
            ->published()
            ->orderBy('event_date', 'asc');

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $events = $query->paginate(12);
        $categories = EventCategory::active()->get();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Display a single published event for the public
     */
    public function publicShow($id)
    {
        $event = Event::with('category', 'tags', 'creator')
            ->where('id', $id)
            ->where('is_published', true)
            ->where('status', Event::STATUS_PUBLISHED)
            ->firstOrFail();

        return view('events.show', compact('event'));
    }

    /**
     * Create default reminders for an event
     */
    private function createDefaultReminders(Event $event)
    {
        // Create email reminders at 1 day and 1 hour before the event
        $reminders = [
            ['type' => 'email', 'minutes' => 1440], // 1 day = 1440 minutes
            ['type' => 'email', 'minutes' => 60],   // 1 hour = 60 minutes
        ];

        foreach ($reminders as $reminder) {
            $eventReminder = EventReminder::create([
                'event_id' => $event->id,
                'reminder_type' => $reminder['type'],
                'minutes_before' => $reminder['minutes'],
            ]);

            // Calculate and set the scheduled time
            $eventReminder->calculateScheduledTime();
        }
    }

    /**
     * Handle featured image upload
     */
    private function handleFeaturedImageUpload($file)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('img/events'), $filename);
        return 'img/events/' . $filename;
    }

    /**
     * Delete featured image file
     */
    private function deleteFeaturedImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}