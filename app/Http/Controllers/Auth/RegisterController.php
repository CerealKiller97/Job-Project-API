<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\RegisterServiceInterface;
use App\Contracts\VerificationTokenServiceInterface;
use App\DTO\Register;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * @var RegisterServiceInterface
     */
    private $registerService;
    /**
     * @var VerificationTokenServiceInterface
     */
    private $verificationTokenService;


    /**
     * RegisterController constructor.
     * @param  RegisterServiceInterface  $registerService
     * @param  VerificationTokenServiceInterface  $verificationTokenService
     */
    public function __construct(
        RegisterServiceInterface $registerService,
        VerificationTokenServiceInterface $verificationTokenService
    ) {
        $this->registerService = $registerService;
        $this->verificationTokenService = $verificationTokenService;
    }

    public function register(RegisterRequest $request): Response
    {
        try {
            $user = $this->registerService->register(new Register($request->validated()));
            return response()->json(['message' => 'Successfully registered.'], 201);
        } catch (Exception $exception) {
            dd($exception->getMessage());
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }
}
