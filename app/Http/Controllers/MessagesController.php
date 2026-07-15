<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactMessage;
use App\Mail\MessageReply;

class MessagesController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(20);

        return view('auth.messages.index', compact('messages'));
    }

    public function show($id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $message = ContactMessage::findOrFail($id);

        // Mark as read if not already
        if (!$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_by' => Auth::id(),
                'read_at' => now()
            ]);
        }

        return view('auth.messages.show', compact('message'));
    }

    public function reply(Request $request, $id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'reply_message' => 'required|string'
        ]);

        $message = ContactMessage::findOrFail($id);

        $message->update([
            'reply_message' => $request->reply_message,
            'replied_by' => Auth::id(),
            'replied_at' => now()
        ]);

        // Send reply email
        try {
            $message->load('replier'); // Eager load the replier relationship
            Mail::to($message->email)->send(new MessageReply($message));
        } catch (\Exception $e) {
            \Log::error('Failed to send message reply email: ' . $e->getMessage());
        }

        return redirect()->route('auth.messages.index')->with('success', 'Reply sent successfully.');
    }

    public function destroy($id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Unauthorized');
        }

        $message = ContactMessage::findOrFail($id);

        // Only allow delete if replied
        if ($message->replied_at) {
            $message->delete();
            return redirect()->route('auth.messages.index')->with('success', 'Message deleted successfully.');
        }

        return redirect()->route('auth.messages.index')->with('error', 'Cannot delete unreplied messages.');
    }
}
