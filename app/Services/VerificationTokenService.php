<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\VerificationTokenServiceInterface;
use App\Exceptions\AccountAlreadyVerifiedException;
use App\Exceptions\InvalidTokenException;
use App\Models\User;
use Tymon\JWTAuth\JWTAuth;

class VerificationTokenService implements VerificationTokenServiceInterface
{
    /**
     * @var JWTAuth
     */
    private $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param  string  $token
     * @return bool
     * @throws InvalidTokenException
     * @throws AccountAlreadyVerifiedException
     */
    public function verify(string $token): bool
    {
        $this->auth->setToken($token);

        $decodedEmail = $this->auth->getPayload()['email'];

        $user = User::query()->where('email', '=', $decodedEmail)->first();

       if ($user === null) {
           throw new InvalidTokenException();
       }

       if ($user->email_verified_at !== null) {
            throw new AccountAlreadyVerifiedException();
       }

       $user->email_verified_at = now();

       return $user->save();

    }
}
