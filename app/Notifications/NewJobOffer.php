<?php

namespace App\Notifications;

use App\Models\JobOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobOffer extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private $urlPublish;

    /**
     * @var string
     */
    private $urlSpam;

    /**
     * @var string
     */
    private $token;


    private $jobOffer;

    /**
     * Create a new notification instance.
     *
     * @param  string  $urlPublish
     * @param  string  $urlSpam
     * @param  string  $token
     * @param  JobOffer  $jobOffer
     */
    public function __construct(string $urlPublish, string $urlSpam, string $token, JobOffer $jobOffer)
    {
        $this->urlPublish = $urlPublish;
        $this->urlSpam = $urlSpam;
        $this->token = $token;
        $this->jobOffer = $jobOffer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have new Job to approve')
            ->line('Job:')

            ->markdown('markdown', [
                'urlPublish' => $this->urlPublish,
                'urlSpam' => $this->urlSpam,
                'title' => $this->jobOffer->title,
                'description' => $this->jobOffer->description
            ])
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
