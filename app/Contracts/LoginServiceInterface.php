<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\LoginDTO;
use App\Exceptions\{EntityNotFoundException, IncorrectPasswordException};

interface LoginServiceInterface
{
    /**
     * @param  LoginDTO  $loginDTO
     * @throws EntityNotFoundException
     * @throws IncorrectPasswordException
     * @return array
     */
    public function login(LoginDTO $loginDTO): array;
}
