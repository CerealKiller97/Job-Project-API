<?php

namespace App\Listeners;

use App\Events\UserNotActive;
use App\Notifications\VerifyUserAccount;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Routing\UrlGenerator;

class UserNotActiveListener
{

    /**
     * @var UrlGenerator
     */
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
     * @param  UserNotActive  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->getUser();
        $url = $this->urlGenerator->signedRoute('verify', [
            'email' => $user->email
        ], Carbon::now()->addMinutes(15));
        $notification = (new VerifyUserAccount($url))->delay(Carbon::now()
            ->addSeconds(10))
            ->onQueue('verify');
        $user->notify($notification);

    }
}
