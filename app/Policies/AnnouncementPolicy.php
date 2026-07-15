<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function view(User $user, Announcement $announcement)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function update(User $user, Announcement $announcement)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function delete(User $user, Announcement $announcement)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function publish(User $user, Announcement $announcement)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function manage_announcements(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }
}