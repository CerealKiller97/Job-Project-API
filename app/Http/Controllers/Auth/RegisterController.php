<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\RegisterServiceInterface;
use App\Contracts\VerificationTokenServiceInterface;
use App\DTO\RegisterDTO;
use App\Exceptions\AccountAlreadyVerifiedException;
use App\Exceptions\InvalidTokenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;
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
            $this->registerService->register(new RegisterDTO($request->validated()));
            return response()->json(['message' => 'Successfully registered.'], 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }

    public function verify(string $token): Response
    {
        try {
            $this->verificationTokenService->verify($token);
            return response()->json(['message' => 'Account successfully verified.'], 200);
        } catch (InvalidTokenException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Invalid verification token.'], 400);
        } catch (AccountAlreadyVerifiedException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Account already verified.'], 400);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }
}
