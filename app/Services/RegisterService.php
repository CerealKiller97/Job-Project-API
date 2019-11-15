<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RegisterServiceInterface;
use App\DTO\Register;
use App\Events\UserRegistred;
use App\Models\User;
use Hashids\HashidsInterface;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Tymon\JWTAuth\JWTAuth;

class RegisterService implements RegisterServiceInterface
{
    /**
     * @var HashidsInterface
     */
    private $hashingService;
    /**
     * @var JWTAuth
     */
    private $jwtService;
    /**
     * @var Hasher
     */
    private $hasher;

    private $eventDispatcher;

    public function __construct(HashidsInterface $hashingService, JWTAuth $auth, Hasher $hasher, EventDispatcher $dispatcher)
    {
        $this->hashingService = $hashingService;
        $this->jwtService = $auth;
        $this->hasher = $hasher;
        $this->eventDispatcher = $dispatcher;
    }

    /**
     * @param  Register  $registerDTO
     * @return User
     */
    public function register(Register $registerDTO): User
    {
        $user = User::create([
            'name' => $registerDTO->name,
            'email' => $registerDTO->email,
            'password' => $this->hasher->make($registerDTO->password),
            'role_id' => $this->hashingService->decode($registerDTO->role_id)[0]
        ]);

        $this->eventDispatcher->dispatch(new UserRegistred($user));

        return $user;
    }
}
