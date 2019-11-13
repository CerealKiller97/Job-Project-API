<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Exceptions\{AccountAlreadyVerifiedException, InvalidTokenException};

interface VerificationTokenServiceInterface
{
    /**
     * @param  string  $token
     * @return bool
     * @throws InvalidTokenException
     * @throws AccountAlreadyVerifiedException
     */
    public function verify(string $token): bool;
}
