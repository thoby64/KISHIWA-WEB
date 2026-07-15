<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;
    protected $daysUntil;

    /**
     * Create a new notification instance.
     */
    public function __construct($event, $daysUntil = 1)
    {
        $this->event = $event;
        $this->daysUntil = $daysUntil;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->daysUntil === 0 ? 
            "Event Today: {$this->event->title}" : 
            "Event Reminder: {$this->event->title} in {$this->daysUntil} day(s)";

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$notifiable->name}!")
            ->line("This is a reminder about an upcoming event:")
            ->line("**{$this->event->title}**")
            ->when($this->event->description, function ($mail) {
                return $mail->line("Description: {$this->event->description}");
            })
            ->line("**Date:** {$this->event->event_date->format('l, F j, Y')}")
            ->when($this->event->event_time, function ($mail) {
                return $mail->line("**Time:** {$this->event->event_time->format('g:i A')}");
            })
            ->when($this->event->location, function ($mail) {
                return $mail->line("**Location:** {$this->event->location}");
            })
            ->when($this->event->category, function ($mail) {
                return $mail->line("**Category:** {$this->event->category->name}");
            })
            ->action('View Event Details', route('events'))
            ->line('We look forward to seeing you there!')
            ->salutation('Best regards, Kishiwa School');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
