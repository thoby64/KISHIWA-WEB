<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\Appointment;
use App\Models\ClassModel;
use App\Models\Teacher;
use App\Models\Gallery;
use App\Policies\EventPolicy;
use App\Policies\AnnouncementPolicy;
use App\Policies\AppointmentPolicy;
use App\Policies\ClassPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\GalleryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        Announcement::class => AnnouncementPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        ClassModel::class => ClassPolicy::class,
        Teacher::class => TeacherPolicy::class,
        Gallery::class => GalleryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();


    }
}