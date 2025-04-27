<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use App\Events\UserRegistered;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify', now()->addMinutes(60), [
                'id' => $event->user->id,
                'hash' => sha1($event->user->email),
            ]
        );
        Mail::to($event->user->email)->send(new WelcomeMail($event->user,$verificationUrl));
    }
}
