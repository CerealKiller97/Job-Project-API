<?php

namespace App\Http\Controllers;

use App\Contracts\JobOffersServiceInterface;
use App\DTO\CreateJobOfferDTO;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\JobOfferRequest;
use App\Http\Requests\JobOfferSearchRequest;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Support\Facades\Log;

class JobOffersController extends Controller
{
    /**
     * @var JobOffersServiceInterface
     */
    private $jobOfferService;

    public function __construct(JobOffersServiceInterface $jobOfferService)
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
         dd($request->getPagedRequest());
        $jobOffers = $this->jobOfferService->getJobs();

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
            $this->jobOfferService->addJobOffer(new CreateJobOfferDTO($request->validated()));
            return response()->json(['message' => 'Successfully added new job.'], 201);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later']);
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
        } catch (EntityNotFoundException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message'=> $exception->getMessage()], 404);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
