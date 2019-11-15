<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\VerificationTokenServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    private $verificationTokenService;

    public function __construct(VerificationTokenServiceInterface $verificationTokenService)
    {
        $this->verificationTokenService = $verificationTokenService;
    }

    public function verify(Request $request): RedirectResponse
    {
        // Email is valid by default because url is signed
        // if user tries to manipulate the url
        // then the request will be discarded by the framework itself
        // so there is no need to verify email again here

        $hasVerified = $this->verificationTokenService->verify($request->query('email'));

        if (!$hasVerified) {
            return redirect(env('FRONTEND_URL') . 'auth/login?msg=already-activated');
        }

        return redirect(env('FRONTEND_URL').'auth/login?msg=success');
    }
}
