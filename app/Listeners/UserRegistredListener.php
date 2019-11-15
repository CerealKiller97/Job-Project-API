<?php

namespace App\Listeners;

use App\Events\UserRegistred;
use App\Notifications\VerifyUserAccount;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Routing\UrlGenerator;

class UserRegistredListener
{
    private $urlGenerator;

    /**
     * Create the event listener.
     *
     * @param  UrlGenerator  $urlGenerator
     */
    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistred  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->getUser();
        $url = $this->urlGenerator->signedRoute('verify', [
            'email' => $user->email,
        ], Carbon::now()->addMinutes(15));

        $notification = (new VerifyUserAccount($url))
            ->onQueue('default')
            ->delay(Carbon::now()->addSeconds(10));

        $user->notify($notification);
    }
}
