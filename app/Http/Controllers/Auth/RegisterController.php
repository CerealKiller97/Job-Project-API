<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\RegisterServiceInterface;
use App\Contracts\VerificationMailServiceInterface;
use App\Contracts\VerificationTokenServiceInterface;
use App\DTO\RegisterDTO;
use App\Exceptions\AccountAlreadyVerifiedException;
use App\Exceptions\InvalidTokenException;
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
     * @var VerificationMailServiceInterface
     */
    private $verficationEmailService;


    /**
     * RegisterController constructor.
     * @param  RegisterServiceInterface  $registerService
     * @param  VerificationTokenServiceInterface  $verificationTokenService
     * @param  VerificationMailServiceInterface  $verificationMailService
     */
    public function __construct(
        RegisterServiceInterface $registerService,
        VerificationTokenServiceInterface $verificationTokenService,
        VerificationMailServiceInterface $verificationMailService
    ) {
        $this->registerService = $registerService;
        $this->verificationTokenService = $verificationTokenService;
        $this->verficationEmailService = $verificationMailService;
    }

    public function register(RegisterRequest $request): Response
    {
        try {
            $jwt = $this->registerService->register(new RegisterDTO($request->validated()));
            $this->verficationEmailService->sendMail($request->email, $jwt);
            return response()->json(['message' => 'Successfully registered.'], 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }
}
