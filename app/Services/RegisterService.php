<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RegisterServiceInterface;
use App\DTO\RegisterDTO;
use App\Models\User;
use Hashids\HashidsInterface;

class RegisterService implements RegisterServiceInterface
{
    /**
     * @var HashidsInterface
     */
    private $hashingService;

    public function __construct(HashidsInterface $hashingService)
    {
        $this->hashingService = $hashingService;
    }

    /**
     * @param  RegisterDTO  $registerDTO
     */
    public function register(RegisterDTO $registerDTO): void
    {
        User::create([
            'name' => $registerDTO->name,
            'email' => $registerDTO->email,
            'password' => bcrypt($registerDTO->password),
            'role_id' => $this->hashingService->decode($registerDTO->role_id)[0]
        ]);
    }
}
