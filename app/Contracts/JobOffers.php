<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateJobOffer;
use App\Http\Resources\Job;
use App\Http\Resources\Jobs;
use App\Models\User;

interface JobOffers
{
    const SPAM = 'spam';
    CONST APPROVE = 'approve';

    /**
     * @param  int  $page
     * @param  int  $perPage
     * @return Jobs
     */
    public function getJobs(int $page, int $perPage): Jobs;

    /**
     * @param  string  $id
     * @return Job
     */
    public function getJobOffer(string $id): Job;

    /**
     * @param  CreateJobOffer  $createJobOfferDTO
     * @param  User  $user
     * @return Job
     */
    public function addJobOffer(CreateJobOffer $createJobOfferDTO, User $user): Job;

    /**
     * @param  string  $id
     * @param  CreateJobOffer  $createJobOfferDTO
     * @return bool
     */
    public function updateJobOffer(string $id, CreateJobOffer $createJobOfferDTO): bool;

    /**
     * @param  string  $id
     * @return bool
     */
    public function deleteJobOffer(string $id): bool;
}
