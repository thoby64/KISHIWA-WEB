{{-- Message Reply Email --}}
<h2>Reply to Your Message</h2>
<p>Dear {{ $contactMessage->name }},</p>
<p>Thank you for contacting Little Stars Daycare and Nursery School. Here is our reply to your message:</p>
<p><strong>Your Original Message:</strong></p>
<p>{{ $contactMessage->message }}</p>
<p><strong>Our Reply:</strong></p>
<p>{{ $contactMessage->reply_message }}</p>
<p>For further communication, please contact {{ $contactMessage->replier->name }} at {{ $contactMessage->replier->email }}.</p>
<p>Best regards,<br>Little Stars Daycare and Nursery School</p>