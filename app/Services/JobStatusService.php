<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\JobStatusServiceInterface;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class JobStatusService implements JobStatusServiceInterface
{
    /**
     * @param  string  $id
     * @param  string  $status
     * @throws ModelNotFoundException
     * @throws Throwable
     */
    public function jobStatus(string $id, string $status): void
    {
        $jobOffer = JobOffer::query()->findOrFail($id);

        $jobOffer->state = $status;

        $jobOffer->saveOrFail();
    }
}
