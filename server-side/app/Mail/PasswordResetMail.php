<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $token;
    protected string $email;
    protected string $fullName;
    protected int $expiryTime;


    /**
     * Create a new message instance.
     */
    public function __construct($fullName, $email, $token, $expiryTime)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->token = $token;
        $this->expiryTime = $expiryTime;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        //  App::setLocale($user->preferred_language);
        return $this->from(config('mail.from.address'), config('app.name'))
            ->subject(__('emails.reset_password.title'))
            ->view('emails.password-reset')
            ->with([
                'fullName' => $this->fullName,
                'token' => $this->token,
                'email' => $this->email,
                'expiryTime' => $this->expiryTime,
            ]);
    }
}
