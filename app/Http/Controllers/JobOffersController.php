<?php

namespace App\Http\Controllers;

use App\Contracts\JobOffers;
use App\DTO\CreateJobOffer;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\JobOfferRequest;
use App\Http\Requests\JobOfferSearchRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Support\Facades\Log;

class JobOffersController extends Controller
{
    /**
     * @var JobOffers
     */
    private $jobOfferService;

    public function __construct(JobOffers $jobOfferService)
    {
        $this->jobOfferService = $jobOfferService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  JobOfferSearchRequest  $request
     * @return Response
     */
    public function index(JobOfferSearchRequest $request): Response
    {
        $jobOffers = $this->jobOfferService->getJobs(1, 5);

        return response()->json($jobOffers, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  JobOfferRequest  $request
     * @return Response
     */
    public function store(JobOfferRequest $request): Response
    {
        try {
            $job = $this->jobOfferService->addJobOffer(new CreateJobOffer($request->validated()), $request->user());
            return response()->json($job, 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return void
     */
    public function show(string $id)
    {
        try {
            $jobOffer = $this->jobOfferService->getJobOffer($id);
            return response()->json($jobOffer, 200);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message'=> "Job offer not found."], 404);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  JobOfferRequest  $request
     * @param  string  $id
     * @return Response
     */
    public function update(JobOfferRequest $request, string $id): Response
    {
        try {
            $job = new CreateJobOffer($request->validated());
            $this->jobOfferService->updateJobOffer($id, $job);
            return response()->json(null, 204);
        }catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 404);
        }
        catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return void
     */
    public function destroy(string $id): Response
    {
    }
}
