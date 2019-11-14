<?php

namespace App\Mail;

use App\Models\JobOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class ModeratorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var JobOffer
     */
    private $job;
    /**
     * @var string
     */
    private $email;

    /**
     * Create a new message instance.
     *
     * @param $job
     * @param  string  $email
     */
    public function __construct($job, string $email)
    {
        $this->job = $job;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'noreply@test.com';
        $subject = 'New Job!';
        $name = 'Softwarehaus project';

        $id = Crypt::encryptString($this->job->id);

        //$desaes = (int) Crypt::decryptString($id);

        // dd($desaes);

        $data = [
          'id' => $id,
          'title' => $this->job->title,
          'description' => $this->job->description
        ];

        return $this->view('emails.moderator')
            ->from($this->email, $name)
            ->cc($address, $name)
            ->bcc($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with([ 'job' => $data ]);
    }
}
