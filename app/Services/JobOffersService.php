<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\JobOffers;
use App\DTO\CreateJobOffer;
use App\Http\Resources\Job;
use App\Http\Resources\Jobs;
use App\Jobs\SendEmailToModerators;
use App\Models\JobOffer as JobOfferModel;
use App\Models\User;
use App\Notifications\FirstJobPosted;
use Hashids\HashidsInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

class JobOffersService implements JobOffers
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
     * @param  int  $page
     * @param  int  $perPage
     * @return Jobs
     */
    public function getJobs(int $page, int $perPage): Jobs
    {
        $jobOffers = JobOfferModel::query()->where('user_id', '=', auth()->user()->id)->paginate($perPage, ['*'], 'page', $page);

        return new Jobs($jobOffers, $this->hashIdsService);
    }

    /**
     * @param  string  $id
     * @return Job
     */
    public function getJobOffer(string $id): Job
    {
        return new  Job(JobOfferModel::query()
            ->findOrFail($this->hashIdsService->decode($id)[0] ?? null), $this->hashIdsService);
    }

    /**
     * @param  CreateJobOffer  $createJobOfferDTO
     * @param  User  $user
     * @return Job
     * @throws Throwable
     */
    public function addJobOffer(CreateJobOffer $createJobOfferDTO, User $user): Job
    {
        /** @var JobOfferModel $job */
        $job = new JobOfferModel([
            'title' => $createJobOfferDTO->title,
            'description' => $createJobOfferDTO->description,
            'email' => $createJobOfferDTO->email,
            'state' => $user->newUser === true ? JobOfferModel::NO_STATE : JobOfferModel::PUBLISHED,
            'valid_until' => $createJobOfferDTO->validUntil
        ]);

        $user->jobOffers()->save($job);

        if ($user->newUser) {
            $user->newUser = false;
            $user->saveOrFail();

            $notification = (new FirstJobPosted($job))->delay(now()->addSeconds(10));

            $user->notify($notification);
            SendEmailToModerators::dispatch($job)
                ->delay(now()->addSeconds(10));
        }


        return new Job($job, $this->hashIdsService);
    }

    /**
     * @param  string  $id
     * @param  CreateJobOffer  $createJobOfferDTO
     * @return bool
     * @throws ModelNotFoundException
     * @throws Throwable
     */
    public function updateJobOffer(string $id, CreateJobOffer $createJobOfferDTO): bool
    {
        DB::beginTransaction();
        $updated = JobOfferModel::query()
                ->where('id', '=', $this->hashIdsService->decode($id)[0] ?? null)
                ->update([
                    'title' => $createJobOfferDTO->title,
                    'description' => $createJobOfferDTO->description,
                    'email' => $createJobOfferDTO->email,
                    'valid_until' => $createJobOfferDTO->validUntil
                ]) > 0;

        if ($updated) {
            DB::commit();
            return true;
        }
        DB::rollBack();
        throw new ModelNotFoundException('Job offer not found.');
    }

    /**
     * @param  string  $id
     * @return bool
     */
    public function deleteJobOffer(string $id): bool
    {
        DB::beginTransaction();
        $deleted = JobOfferModel::destroy($this->hashIdsService->decode($id)[0] ?? null) > 0;

        if ($deleted) {
            DB::commit();
            return true;
        }

        DB::rollBack();
        throw new ModelNotFoundException("Job offer not found");
    }
}
