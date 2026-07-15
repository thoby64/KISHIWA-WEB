<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\AppointmentNotification;
use App\Mail\NewAppointmentNotification;
use App\Mail\AppointmentConfirmed;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }
        
        $appointments = Appointment::orderBy('created_at', 'desc')->paginate(20);
        
        return view('auth.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointment');
    }

    public function store(Request $request)
    {
        $request->validate([
            'guardian_name' => 'required|string|max:255',
            'guardian_email' => 'required|email|max:255',
            'child_name' => 'required|string|max:255',
            'child_age' => 'required|string|max:10',
            'message' => 'nullable|string'
        ]);

        try {
            $appointment = Appointment::create([
                'guardian_name' => $request->guardian_name,
                'guardian_email' => $request->guardian_email,
                'child_name' => $request->child_name,
                'child_age' => $request->child_age,
                'message' => $request->message,
            ]);

            // Send notification emails to configured users
            $notificationUsers = AppointmentNotification::with('user')->get();
            foreach ($notificationUsers as $notif) {
                Mail::to($notif->user->email)->send(new NewAppointmentNotification($appointment));
            }

            return redirect()->route('appointment.create')->with('success', 'Appointment request submitted successfully. We will contact you soon.');
        } catch (\Exception $e) {
            \Log::error('Appointment submission failed: ' . $e->getMessage());
            return redirect()->route('appointment.create')->with('error', 'Appointment submission failed. Please try again later and ensure your email is valid.');
        }
    }

    public function confirm(Request $request, $id)
    {
        // Find the appointment first, then authorize against the policy
        $appointment = Appointment::findOrFail($id);
        $this->authorize('confirm', $appointment);

        $request->validate([
            'appointment_date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
        ]);

        $appointment->update([
            'is_confirmed' => true,
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
            'appointment_date' => $request->appointment_date,
            'location' => $request->location,
        ]);

        // Send confirmation email to the guardian
        try {
            Mail::to($appointment->guardian_email)->send(new AppointmentConfirmed($appointment));
        } catch (\Exception $e) {
            \Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());
            // Still proceed, as appointment is confirmed
        }

        return redirect()->back()->with('success', 'Appointment confirmed successfully.');
    }
}