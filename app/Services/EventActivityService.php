<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class EventActivityService
{
    public static function logEventCreated(Event $event)
    {
        EventActivityLog::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'action' => EventActivityLog::ACTION_CREATED,
            'description' => "Event '{$event->title}' was created",
            'ip_address' => Request::ip(),
        ]);
    }

    public static function logEventUpdated(Event $event, array $changes = [])
    {
        $description = "Event '{$event->title}' was updated";
        
        if (!empty($changes)) {
            $changedFields = implode(', ', array_keys($changes));
            $description .= " ({$changedFields})";
        }

        EventActivityLog::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'action' => EventActivityLog::ACTION_UPDATED,
            'description' => $description,
            'ip_address' => Request::ip(),
        ]);
    }

    public static function logStatusChanged(Event $event, $oldStatus, $newStatus)
    {
        EventActivityLog::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'action' => EventActivityLog::ACTION_STATUS_CHANGED,
            'old_value' => $oldStatus,
            'new_value' => $newStatus,
            'description' => "Status changed from '{$oldStatus}' to '{$newStatus}'",
            'ip_address' => Request::ip(),
        ]);
    }

    public static function logEventDeleted(Event $event)
    {
        EventActivityLog::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'action' => EventActivityLog::ACTION_DELETED,
            'description' => "Event '{$event->title}' was deleted",
            'ip_address' => Request::ip(),
        ]);
    }

    public static function logAttachmentAdded(Event $event, $fileName)
    {
        EventActivityLog::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'action' => EventActivityLog::ACTION_ATTACHMENT_ADDED,
            'description' => "Attachment '{$fileName}' was added",
            'ip_address' => Request::ip(),
        ]);
    }

    public static function logAttachmentRemoved(Event $event, $fileName)
    {
        EventActivityLog::create([
            'event_id' => $event->id,
            'user_id' => Auth::id(),
            'action' => EventActivityLog::ACTION_ATTACHMENT_REMOVED,
            'description' => "Attachment '{$fileName}' was removed",
            'ip_address' => Request::ip(),
        ]);
    }
}
