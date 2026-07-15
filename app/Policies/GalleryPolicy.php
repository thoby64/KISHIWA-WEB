<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Gallery;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function view(User $user, Gallery $gallery)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function update(User $user, Gallery $gallery)
    {
        return ($user->role === 'admin' || $user->role === 'manager') && 
               ($user->id === $gallery->created_by || $user->role === 'admin');
    }

    public function delete(User $user, Gallery $gallery)
    {
        return ($user->role === 'admin' || $user->role === 'manager') && 
               ($user->id === $gallery->created_by || $user->role === 'admin');
    }

    public function manage_gallery(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }
}