<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RegisterServiceInterface;
use App\DTO\RegisterDTO;
use App\Models\User;
use Hashids\HashidsInterface;
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

    public function __construct(HashidsInterface $hashingService, JWTAuth $auth)
    {
        $this->hashingService = $hashingService;
        $this->jwtService = $auth;
    }

    /**
     * @param  RegisterDTO  $registerDTO
     * @return string
     */
    public function register(RegisterDTO $registerDTO): string
    {
        $user = User::create([
            'name' => $registerDTO->name,
            'email' => $registerDTO->email,
            'password' => bcrypt($registerDTO->password),
            'role_id' => $this->hashingService->decode($registerDTO->role_id)[0]
        ]);

        return $this->jwtService->fromUser($user);
    }
}
