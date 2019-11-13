<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\LoginServiceInterface;
use App\DTO\LoginDTO;
use App\Exceptions\{AccountNotVerifiedException, EntityNotFoundException, IncorrectPasswordException};
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Tymon\JWTAuth\JWTAuth;

class LoginService implements LoginServiceInterface
{
    /**
     * @var Hasher
     */
    private $hasher;
    /**
     * @var JWTAuth
     */
    private $jwtAuth;

    public function __construct(Hasher $hasher, JWTAuth $auth)
    {
        $this->hasher = $hasher;
        $this->jwtAuth = $auth;
    }

    /**
     * @param  LoginDTO  $loginDTO
     * @throws EntityNotFoundException
     * @throws IncorrectPasswordException
     * @throws AccountNotVerifiedException
     * @return array
     */
    public function login(LoginDTO $loginDTO): array
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('email', '=', $loginDTO->email)->first();

        if ($user === null) {
            throw new EntityNotFoundException();
        }

        if (!$this->hasher->check($loginDTO->password, $user->password)) {
            throw new IncorrectPasswordException();
        }

        if (!$user->hasVerifiedEmail()) {
            throw new AccountNotVerifiedException();
        }

        $token = $this->jwtAuth->fromUser($user);

        return [
          'token'  => $token,
          'user' => $user->getJWTCustomClaims()
        ];
    }
}
