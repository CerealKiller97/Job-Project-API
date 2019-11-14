<?php

namespace App\Http\Controllers;

use App\Contracts\JobStatusServiceInterface;
use App\Exceptions\EntityNotFoundException;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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
     * @param  string  $id
     * @param  string  $status
     * @return Factory|View
     */
    public function status(string $id, string $status)
    {
        try {
            $this->jobStatusService->jobStatus($id, $status);
            return view('welcome');
        } catch (EntityNotFoundException $exception) {
            Log::error($exception->getMessage());
        }
        catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
