<?php

namespace App\Jobs;

use App\Models\JobOffer;
use App\Models\User;
use App\Notifications\NewJobOffer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\JWTAuth;

class SendEmailToModerators implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $jobOffer;

    /**
     * Create a new job instance.
     *
     * @param  JobOffer  $jobOffer
     */
    public function __construct(JobOffer $jobOffer)
    {
        $this->jobOffer = $jobOffer;
    }

    /**
     * Execute the job.
     *
     * @param  UrlGenerator  $urlGenerator
     * @param  JWTAuth  $auth
     * @return void
     */
    public function handle(UrlGenerator $urlGenerator, JWTAuth $auth)
    {
        /** @var User[] $users */
        $users = User::query()->with('role')
            ->where('role_id', '=', 2)
            ->cursor();

        Log::error(json_encode($users));
        foreach ($users as $user) {
            $token = $auth->fromUser($user);
            $urlPublish = $urlGenerator->signedRoute('job_status', [
                'id' => $this->jobOffer->id,
                'state' => JobOffer::PUBLISHED,
                'token' => $token
            ]);
            $urlSpam = $urlGenerator->signedRoute('job_status', [
                'id' => $this->jobOffer->id,
                'state' => JobOffer::SPAM,
                'token' => $token
            ]);
            $user->notify((new NewJobOffer($urlPublish, $urlSpam, $token, $this->jobOffer))
                ->delay(Carbon::now()->addSeconds(10)));
        }
    }
}
