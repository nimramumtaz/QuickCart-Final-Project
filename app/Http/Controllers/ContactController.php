<?php

namespace App\Http\Controllers;

use App\Mail\ContactReceivedMail;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function message(Request $request)
    {
        $message = ContactMessage::create($request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['nullable', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'department' => ['required', 'string', 'max:80'],
            'message' => ['required', 'string', 'max:1200'],
        ]));

        try {
            Mail::to($message->email)->send(new ContactReceivedMail($message));
        } catch (\Throwable $e) {
            Log::warning('Contact email could not be sent', ['error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Message saved. We will reply soon.']);
    }

    public function newsletter(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email', 'max:120']]);

        $subscriber = NewsletterSubscriber::firstOrCreate(
            ['email' => $data['email']],
            ['coupon_code' => 'QC10-' . random_int(1000, 9999)]
        );

        return response()->json([
            'message' => 'Subscribed successfully.',
            'coupon_code' => $subscriber->coupon_code,
        ]);
    }
}
