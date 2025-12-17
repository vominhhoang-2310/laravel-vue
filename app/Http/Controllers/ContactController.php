<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact');
    }

    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'max:20480'],
        ]);

        $to = env('MAIL_TO_ADDRESS', config('mail.from.address'));

        $attachment = $request->file('attachment');
        $body = "Name: {$validated['name']}\nEmail: {$validated['email']}\nSubject: {$validated['subject']}\n\n{$validated['message']}";

        Mail::send([], [], function ($mail) use ($to, $validated, $attachment, $body) {
            $mail->to($to)
                ->replyTo($validated['email'], $validated['name'])
                ->subject('Story Time: ' . $validated['subject'])
                ->text($body);

            if ($attachment) {
                $mail->attach($attachment->getRealPath(), [
                    'as' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getClientMimeType(),
                ]);
            }
        });

        return redirect()
            ->route('contact')
            ->with('success', 'Your message has been successfully sent.');
    }
}
