<?php

namespace App\Contracts;

interface VerificationMailServiceInterface
{
    /**
     * @param  string  $email
     * @param  string  $jwt
     */
    public function sendMail(string $email, string $jwt): void;
}
