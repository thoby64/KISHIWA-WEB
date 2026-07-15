<?php

namespace App\Console\Commands;

use App\Models\EventReminder;
use App\Models\User;
use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send pending event reminders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for pending event reminders...');

        // Get pending reminders that are due
        $pendingReminders = EventReminder::with('event.category')
            ->pending()
            ->get();

        if ($pendingReminders->isEmpty()) {
            $this->info('No pending reminders found.');
            return;
        }

        $this->info("Found {$pendingReminders->count()} pending reminder(s) to send.");

        $sentCount = 0;

        foreach ($pendingReminders as $reminder) {
            $event = $reminder->event;

            if (!$event) {
                $this->warn("Event not found for reminder ID: {$reminder->id}");
                continue;
            }

            // Calculate days until event for the notification
            $daysUntil = now()->diffInDays($event->event_date, false);

            // Get recipients based on reminder type
            $recipients = $this->getRecipientsForReminder($reminder);

            if ($recipients->isEmpty()) {
                $this->warn("No recipients found for reminder ID: {$reminder->id}");
                continue;
            }

            try {
                $this->line("Sending {$reminder->reminder_type} reminder for: {$event->title}");

                if ($reminder->reminder_type === EventReminder::TYPE_EMAIL) {
                    Notification::send($recipients, new EventReminderNotification($event, $daysUntil));
                }

                // Mark reminder as sent
                $reminder->markAsSent();
                $sentCount++;

            } catch (\Exception $e) {
                $this->error("Failed to send reminder ID {$reminder->id}: {$e->getMessage()}");
            }
        }

        $this->info("Successfully sent {$sentCount} reminder(s).");
    }

    /**
     * Get recipients for the reminder based on type
     */
    private function getRecipientsForReminder(EventReminder $reminder)
    {
        // For now, send to all admins and managers
        // In the future, this could be extended to send to specific users or groups
        return User::whereIn('role', ['admin', 'manager'])->get();
    }
}
