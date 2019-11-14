<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateJobOfferDTO;
use App\DTO\JobOfferDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\JobOffer;

interface JobOffersServiceInterface
{
    const SPAM = 'spam';
    CONST APPROVE = 'approve';
    /**
     * @return array
     */
    public function getJobs(): array;

    /**
     * @param  string  $id
     * @return JobOfferDTO
     */
    public function getJobOffer(string $id): JobOfferDTO;

    /**
     * @param  CreateJobOfferDTO  $createJobOfferDTO
     */
    public function addJobOffer(CreateJobOfferDTO $createJobOfferDTO): void;

    /**
     * @param  string  $id
     * @param  CreateJobOfferDTO  $createJobOfferDTO
     */
    public function updateJobOffer(string $id, CreateJobOfferDTO $createJobOfferDTO): void;

    /**
     * @param  string  $id
     */
    public function deleteJobOffer(string $id): void;
}
