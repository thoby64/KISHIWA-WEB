<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function view(User $user, Appointment $appointment)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function create(User $user)
    {
        return true; // Allow anyone to create appointments
    }

    public function update(User $user, Appointment $appointment)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function confirm(User $user, Appointment $appointment)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }

    public function manage_appointments(User $user)
    {
        return $user->role === 'admin' || $user->role === 'manager';
    }
}