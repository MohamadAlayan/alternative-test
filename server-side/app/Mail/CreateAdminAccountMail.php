<?php

namespace App\Mail;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateAdminAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;
    protected string $password;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $password
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.create-admin-account')
            ->with([
                'firstName' => $this->user->first_name,
                'lastName' => $this->user->last_name,
                'email' => $this->user->email,
                'password' => $this->password,
            ]);
    }
}
