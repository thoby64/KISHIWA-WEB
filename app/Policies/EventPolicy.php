<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function view(User $user, Event $event)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function update(User $user, Event $event)
    {
        // Allow admins and managers to update any event. Managers previously
        // were limited to events they created; change allows full management.
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function delete(User $user, Event $event)
    {
        // Allow admins and managers to delete any event.
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function manage_events(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }
}