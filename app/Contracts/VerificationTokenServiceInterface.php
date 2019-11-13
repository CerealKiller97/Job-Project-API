<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Exceptions\InvalidTokenException;

interface VerificationTokenServiceInterface
{
    /**
     * @param  string  $token
     * @return bool
     * @throws InvalidTokenException
     */
    public function verify(string $token): bool;
}
