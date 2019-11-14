<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\JobStatusServiceInterface;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\JobOfferAlreadyApprovedException;
use App\Exceptions\JobOfferIsAlreadySpamException;
use App\Models\JobOffer;
use Illuminate\Support\Facades\Crypt;

class JobStatusService implements JobStatusServiceInterface
{

    /**
     * @param  string  $id
     * @param  string  $status
     * @throws EntityNotFoundException
     * @throws JobOfferAlreadyApprovedException
     * @throws JobOfferIsAlreadySpamException
     */
    public function jobStatus(string $id, string $status): void
    {
        $decryptedID = (int) Crypt::decryptString($id);

        $jobOffer = JobOffer::find($decryptedID);

        if ($jobOffer === null) {
            throw new EntityNotFoundException("Job offer");
        }

        if ($jobOffer->isSpam === 1) {
           throw new JobOfferIsAlreadySpamException();
        }

        if ($jobOffer->isPublished === 1) {
            throw new JobOfferAlreadyApprovedException();
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
