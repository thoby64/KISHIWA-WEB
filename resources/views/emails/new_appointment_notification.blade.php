{{-- New Appointment Notification Email --}}
<h2>New Appointment Request</h2>
<p>A new appointment has been submitted by {{ $appointment->guardian_name }}.</p>
<p><strong>Details:</strong></p>
<ul>
    <li>Name: {{ $appointment->guardian_name }}</li>
    <li>Email: {{ $appointment->guardian_email }}</li>
    <li>Child Name: {{ $appointment->child_name }}</li>
    <li>Child Age: {{ $appointment->child_age }}</li>
    <li>Message: {{ $appointment->message }}</li>
</ul>
<p>Please log in to the system to confirm this appointment and set a date.</p>
<p><a href="{{ route('auth.appointments.index') }}">View Appointments</a></p>