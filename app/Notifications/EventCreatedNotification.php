<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $eventDateTime = $this->event->event_date->format('F j, Y');
        if ($this->event->event_time) {
            $eventDateTime .= ' at ' . $this->event->event_time->format('g:i A');
        }

        return (new MailMessage)
            ->subject('New Event Created: ' . $this->event->title)
            ->greeting('Hello!')
            ->line('A new event has been created.')
            ->line('**Event:** ' . $this->event->title)
            ->line('**Date:** ' . $eventDateTime)
            ->line('**Location:** ' . ($this->event->location ?? 'TBD'))
            ->action('View Event', route('auth.events.edit', $this->event))
            ->line('Thank you for using Kishiwa School Management System!');
    }
}
