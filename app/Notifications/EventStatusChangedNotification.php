<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;
    public $oldStatus;
    public $newStatus;

    public function __construct(Event $event, $oldStatus, $newStatus)
    {
        $this->event = $event;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statusLabel = match($this->newStatus) {
            'published' => 'Published',
            'draft' => 'Draft',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            default => ucfirst($this->newStatus)
        };

        $eventDateTime = $this->event->event_date->format('F j, Y');
        if ($this->event->event_time) {
            $eventDateTime .= ' at ' . $this->event->event_time->format('g:i A');
        }

        return (new MailMessage)
            ->subject('Event Status Updated: ' . $this->event->title)
            ->greeting('Hello!')
            ->line('An event status has been updated.')
            ->line('**Event:** ' . $this->event->title)
            ->line('**New Status:** ' . $statusLabel)
            ->line('**Date:** ' . $eventDateTime)
            ->action('View Event', route('auth.events.edit', $this->event))
            ->line('Thank you for using Kishiwa School Management System!');
    }
}
