<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\VerificationTokenServiceInterface;
use App\Exceptions\AccountAlreadyVerifiedException;
use App\Exceptions\InvalidTokenException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    private $verificationTokenService;

    public function __construct(VerificationTokenServiceInterface $verificationTokenService)
    {
        $this->verificationTokenService = $verificationTokenService;
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
