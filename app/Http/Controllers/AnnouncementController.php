<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $this->authorize('manage_announcements', Announcement::class);
        
        $announcements = Announcement::with('creator')->latest()->paginate(20);
        return view('auth.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $this->authorize('manage_announcements', Announcement::class);
        
        return view('auth.announcements.create');
    }

    public function store(Request $request)
    {
        $this->authorize('manage_announcements', Announcement::class);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_urgent' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'is_urgent' => $request->is_urgent ?? false,
            'is_published' => $request->is_published ?? false,
            'published_at' => $request->published_at,
            'created_by' => Auth::id()
        ];

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/announcements'), $filename);
            $data['featured_image'] = 'img/announcements/' . $filename;
        }

        Announcement::create($data);

        return redirect()->route('auth.announcements.index')->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        
        return view('auth.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_urgent' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'is_urgent' => $request->is_urgent ?? false,
            'is_published' => $request->is_published ?? false,
            'published_at' => $request->published_at,
            'updated_by' => Auth::id()
        ];

        // Handle featured image upload and delete old
        if ($request->hasFile('featured_image')) {
            if ($announcement->featured_image) {
                $old = public_path($announcement->featured_image);
                if (file_exists($old)) @unlink($old);
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/announcements'), $filename);
            $data['featured_image'] = 'img/announcements/' . $filename;
        }

        $announcement->update($data);

        return redirect()->route('auth.announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Request $request, Announcement $announcement)
    {
        $this->authorize('delete', $announcement);

        // delete featured image file
        if ($announcement->featured_image) {
            $full = public_path($announcement->featured_image);
            if (file_exists($full)) @unlink($full);
        }

        $announcement->delete();

        if ($request->wantsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json(['success' => true, 'message' => 'Announcement deleted successfully.']);
        }

        return redirect()->route('auth.announcements.index')->with('success', 'Announcement deleted successfully.');
    }

    public function publish(Announcement $announcement)
    {
        $this->authorize('publish', $announcement);
        
        $announcement->update([
            'is_published' => true,
            'published_at' => now(),
            'published_by' => Auth::id()
        ]);
        
        return redirect()->back()->with('success', 'Announcement published successfully.');
    }
}