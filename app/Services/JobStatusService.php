<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\JobStatusServiceInterface;
use App\Exceptions\EntityNotFoundException;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Crypt;

class JobStatusService implements JobStatusServiceInterface
{

    /**
     * @param  string  $id
     * @param  string  $status
     * @throws EntityNotFoundException
     */
    public function jobStatus(string $id, string $status): void
    {
        $decryptedID = (int) Crypt::decryptString($id);

        $jobOffer = JobOffer::find($decryptedID);

        if ($jobOffer === null) {
            throw new EntityNotFoundException("Job offer");
        }

        if ($status === static::APPROVE) {
            $jobOffer->isSpam = false;
            $jobOffer->isPublished = true;
        } elseif ($status === static::SPAM) {
            $jobOffer->isSpam = true;
            $jobOffer->isPublished = false;
        }

        $jobOffer->save();
    }
}
