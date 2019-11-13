<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private $jwt;
    /**
     * @var string
     */
    private $email;

    /**
     * Create a new message instance.
     *
     * @param  string  $email
     * @param  string  $jwt
     */
    public function __construct(string $email, string $jwt)
    {
        $this->email = $email;
        $this->jwt = $jwt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'noreply@test.com';
        $subject = 'Account verification!';
        $name = 'Softwarehaus project';

        return $this->view('emails.verificationAccount')
            ->from($this->email, $name)
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with([ 'token' => $this->jwt ]);
    }
}
