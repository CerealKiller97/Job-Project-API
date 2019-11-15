<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\Login;
use App\Exceptions\{AccountNotVerifiedException, IncorrectPasswordException};
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface LoginServiceInterface
{
    /**
     * @param  Login  $loginDTO
     * @return array
     * @throws IncorrectPasswordException
     * @throws AccountNotVerifiedException
     * @throws ModelNotFoundException
     */
    public function login(Login $loginDTO): array;
}
