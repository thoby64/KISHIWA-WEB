<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\SecureLoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\AppointmentNotificationController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Models\User;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/classes', [ClassController::class, 'publicIndex'])->name('classes');
Route::get('/classes/{id}', [ClassController::class, 'show'])->name('classes.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/events', [EventController::class, 'publicIndex'])->name('events');
Route::get('/events/{id}', [EventController::class, 'publicShow'])->name('events.show');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');
Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment.create');
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');

// Secure admin login route - accessible only through a specific path for employees
Route::get('/secure-login', [SecureLoginController::class, 'showLoginForm'])->name('login');
Route::post('/secure-login', [SecureLoginController::class, 'login']);
Route::post('/logout', [SecureLoginController::class, 'logout'])->name('logout');

// Profiles update
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Settings
Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');

// Admin and Manager routes (require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user && $user->role === User::ROLE_ADMIN) {
            try {
                return app(\App\Http\Controllers\Admin\AdminDashboardController::class)->index();
            } catch (\Exception $e) {
                return back()->withErrors(['dashboard' => 'Failed to load admin dashboard: ' . $e->getMessage()]);
            }
        } elseif ($user && $user->role === User::ROLE_MANAGER) {
            try {
                return app(\App\Http\Controllers\Manager\ManagerDashboardController::class)->index();
            } catch (\Exception $e) {
                return back()->withErrors(['dashboard' => 'Failed to load manager dashboard: ' . $e->getMessage()]);
            }
        } else {
            return redirect()->route('home')->withErrors(['dashboard' => 'You do not have permission to access the dashboard.']);
        }
    })->name('dashboard');

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        // Contact messages management
        Route::get('/admin/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts.index');
        //classes management 
        Route::resource('admin/classes', ClassController::class)->names([
            'index' => 'admin.classes.index',
            'create' => 'admin.classes.create',
            'store' => 'admin.classes.store',
            'show' => 'admin.classes.show',
            'edit' => 'admin.classes.edit',
            'update' => 'admin.classes.update',
            'destroy' => 'admin.classes.destroy'
        ]);

        //users management
        Route::resource('admin/users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy'
        ]);
        

        // Audit logs and users activity 
        Route::get('/admin/audit', [AuditController::class, 'index'])->name('admin.audit.index');
        Route::get('/admin/audit/user/{userId}', [AuditController::class, 'userActivity'])->name('admin.audit.user');
        Route::post('/admin/users/{userId}/deactivate', [AuditController::class, 'deactivateUser'])->name('admin.users.deactivate');
        Route::post('/admin/users/{userId}/activate', [AuditController::class, 'activateUser'])->name('admin.users.activate');
        Route::post('/admin/users/{userId}/delete', [AuditController::class, 'deleteUser'])->name('admin.users.delete');

        //user activity 
        Route::get('/admin/users/activity', [AuditController::class, 'activity'])->name('admin.users.activity');

        // Appointment notifications management
        Route::get('/admin/appointment-notifications', [AppointmentNotificationController::class, 'index'])->name('admin.appointment-notifications.index');
        Route::post('/admin/appointment-notifications', [AppointmentNotificationController::class, 'store'])->name('admin.appointment-notifications.store');
        Route::delete('/admin/appointment-notifications/{userId}', [AppointmentNotificationController::class, 'destroy'])->name('admin.appointment-notifications.destroy');

    });

    // Manager and Admin routes
    Route::middleware(['role:admin,manager'])->group(function () {
        // Events management
        Route::resource('auth/events', EventController::class)->names([
            'index' => 'auth.events.index',
            'create' => 'auth.events.create',
            'store' => 'auth.events.store',
            'show' => 'auth.events.show',
            'edit' => 'auth.events.edit',
            'update' => 'auth.events.update',
            'destroy' => 'auth.events.destroy'
        ]);
        Route::post('auth/events/bulk-update', [EventController::class, 'bulkUpdate'])->name('auth.events.bulk-update');

        // Announcements management
        Route::resource('auth/announcements', AnnouncementController::class)->names([
            'index' => 'auth.announcements.index',
            'create' => 'auth.announcements.create',
            'store' => 'auth.announcements.store',
            'show' => 'auth.announcements.show',
            'edit' => 'auth.announcements.edit',
            'update' => 'auth.announcements.update',
            'destroy' => 'auth.announcements.destroy'
        ]);
        Route::post('/auth/announcements/{announcement}/publish', [AnnouncementController::class, 'publish'])->name('auth.announcements.publish');

        // Appointments management
        Route::get('/auth/appointments', [AppointmentController::class, 'index'])->name('auth.appointments.index');
        Route::post('/auth/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('auth.appointments.confirm');

        // Messages management
        Route::get('/auth/messages', [MessagesController::class, 'index'])->name('auth.messages.index');
        Route::get('/auth/messages/{id}', [MessagesController::class, 'show'])->name('auth.messages.show');
        Route::post('/auth/messages/{id}/reply', [MessagesController::class, 'reply'])->name('auth.messages.reply');
        Route::delete('/auth/messages/{id}', [MessagesController::class, 'destroy'])->name('auth.messages.destroy');

        // Classes management
        Route::resource('auth/classes', ClassController::class)->names([
            'index' => 'auth.classes.index',
            'create' => 'auth.classes.create',
            'store' => 'auth.classes.store',
            'show' => 'auth.classes.show',
            'edit' => 'auth.classes.edit',
            'update' => 'auth.classes.update',
            'destroy' => 'auth.classes.destroy'
        ]);

    });
});