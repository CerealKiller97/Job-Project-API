<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\VerificationMailServiceInterface;
use App\Mail\VerificationAccountMail;
use Illuminate\Support\Facades\Mail;

class VerificationMailService implements VerificationMailServiceInterface
{

    /**
     * @param  string  $email
     * @param  string  $jwt
     * @return void
     */
    public function sendMail(string $email, string $jwt): void
    {
        Mail::to($email)->send(new VerificationAccountMail($email, $jwt));
    }
}
