<?php

namespace App\Http\Controllers;

use App\Contracts\JobStatusServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobOfferStatusController extends Controller
{

    /**
     * @var JobStatusServiceInterface
     */
    private $jobStatusService;

    public function __construct(JobStatusServiceInterface $jobStatusService)
    {
        $this->jobStatusService = $jobStatusService;
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function status(Request $request): RedirectResponse
    {
        try {
            $id = $request->query('id');
            $status = $request->query('state');
            $this->jobStatusService->jobStatus($id, $status);
            return redirect(env('FRONTEND_URL').'auth/login');
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Job offer is not found'], 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['message' => 'Status is not valid'], 422);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Error while updating job offer'], 500);
        }
    }
}
