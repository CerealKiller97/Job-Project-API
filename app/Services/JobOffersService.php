<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\JobOffersServiceInterface;
use App\DTO\CreateJobOfferDTO;
use App\DTO\JobOfferDTO;
use App\Exceptions\EntityNotFoundException;
use App\Models\JobOffer;
use Carbon\Carbon;
use Hashids\HashidsInterface;

class JobOffersService implements JobOffersServiceInterface
{
    /**\
     * @var HashidsInterface
     */
    private $hashIdsService;

    public function __construct(HashidsInterface $hashIdsService)
    {
        $this->hashIdsService = $hashIdsService;
    }

    /**
     * @return array
     */
    public function getJobs(): array
    {
//        $jobOffers = JobOffer::all();
//
//        $arr = [];
//
//        foreach ($jobOffers as $jobOffer) {
//            $jobDTO = new JobOfferDTO();
//
//            $arr[] = $this->mapDTO($jobOffer, $jobDTO);
//        }

        return [];
    }

    /**
     * @param  string  $id
     * @return JobOfferDTO
     * @throws EntityNotFoundException
     */
    public function getJobOffer(string $id): JobOfferDTO
    {
        $jobOffer = JobOffer::find($this->hashIdsService->decode($id)[0] ?? null);

        if ($jobOffer === null) {
            throw new EntityNotFoundException("Job offer");
        }

        $jobDto = new JobOfferDTO();

        return $this->mapDTO($jobOffer, $jobDto);
    }

    /**
     * @param  CreateJobOfferDTO  $createJobOfferDTO
     */
    public function addJobOffer(CreateJobOfferDTO $createJobOfferDTO): void
    {
        $job = auth()->user()->jobOffers()->create([
            'title' => $createJobOfferDTO->title,
            'description' => $createJobOfferDTO->description,
            'email' => $createJobOfferDTO->email,
            'isSpam' => null,
            'isPublished' => null,
            'valid_until' => $createJobOfferDTO->valid_until
        ]);

        $jobs = auth()->user()->jobOffers;

        if (count($jobs) === 1) {
            dd('email');
            //email,
        } else {
            $job->isPublished = true;
            $job->save();
        }
    }

    /**
     * @param  string  $id
     * @param  CreateJobOfferDTO  $createJobOfferDTO
     * @throws EntityNotFoundException
     */
    public function updateJobOffer(string $id, CreateJobOfferDTO $createJobOfferDTO): void
    {
        $jobOffer = JobOffer::find($this->hashids->decode($id)[0] ?? null);

        if ($jobOffer === null) {
            throw new EntityNotFoundException("Role");
        }

        if ($jobOffer->title !== $createJobOfferDTO->title) {
            $jobOffer->title = $createJobOfferDTO->title;
        }

        if ($jobOffer->description !== $createJobOfferDTO->description) {
            $jobOffer->description = $createJobOfferDTO->description;
        }

        if ($jobOffer->email !== $createJobOfferDTO->email) {
            $jobOffer->email = $createJobOfferDTO->email;
        }

        if ($jobOffer->valid_until !== $createJobOfferDTO->valid_until) {
            $jobOffer->valid_until = $createJobOfferDTO->valid_until;
        }

        $jobOffer->save();
    }

    /**
     * @param  string  $id
     * @throws EntityNotFoundException
     */
    public function deleteJobOffer(string $id): void
    {
        $jobOffer = JobOffer::find($this->hashids->decode($id)[0] ?? null);

        if ($jobOffer === null) {
            throw new EntityNotFoundException("Job offer");
        }

        $jobOffer->delete();
    }

    private function mapDTO(object $jobOfferDB, JobOfferDTO $jobOfferDTO): JobOfferDTO
    {
        $jobOfferDTO->id = $this->hashIdsService->encode($jobOfferDB->id);
        $jobOfferDTO->title = $jobOfferDB->title;
        $jobOfferDTO->description = $jobOfferDB->description;
        $jobOfferDTO->email = $jobOfferDB->email;
        $jobOfferDTO->isPublished = $jobOfferDB->isPublished;
        $jobOfferDTO->isSpan = $jobOfferDB->isSpan;
        $jobOfferDTO->valid_until =  Carbon::parse($jobOfferDB->valid_until)->format('d.m.Y');

        return $jobOfferDTO;
    }
}
