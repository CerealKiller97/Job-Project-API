<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\Register;
use App\Models\User;

interface RegisterServiceInterface
{
    /**
     * @param  Register  $registerDTO
     * @return User
     */
    public function register(Register $registerDTO): User;
}
