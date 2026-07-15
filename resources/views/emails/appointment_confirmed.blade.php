{{-- Appointment Confirmed Email --}}
<h2>Your Appointment Has Been Confirmed</h2>
<p>Dear {{ $appointment->guardian_name }},</p>
<p>Your appointment request has been confirmed. Here are the details:</p>
<ul>
    <li>Child Name: {{ $appointment->child_name }}</li>
    <li>Child Age: {{ $appointment->child_age }}</li>
    <li>Scheduled Date: {{ $appointment->appointment_date->format('F j, Y \a\t g:i A') }}</li>
    @if(!empty($appointment->location))
        <li>Location: {{ $appointment->location }}</li>
    @endif
</ul>
<p>For further communication, please contact {{ $appointment->confirmer->name }} at {{ $appointment->confirmer->email }}.</p>
<p>Thank you for choosing Little Stars Daycare and Nursery School.</p>