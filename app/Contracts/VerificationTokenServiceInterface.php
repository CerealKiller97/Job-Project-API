<?php

declare(strict_types=1);

namespace App\Contracts;

interface VerificationTokenServiceInterface
{
    /**
     * @param  string  $email
     * @return bool
     */
    public function verify(string $email): bool;
}
