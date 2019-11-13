<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\RegisterDTO;

interface RegisterServiceInterface
{
    /**
     * @param  RegisterDTO  $registerDTO
     * @return string
     */
    public function register(RegisterDTO $registerDTO): string;
}
