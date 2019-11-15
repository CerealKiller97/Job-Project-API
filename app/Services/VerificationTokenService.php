<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\VerificationTokenServiceInterface;
use App\Exceptions\AccountAlreadyVerifiedException;
use App\Exceptions\InvalidTokenException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
     * @param  string  $email
     * @return bool
     */
    public function verify(string $email): bool
    {

        DB::beginTransaction();

        $updated = User::query()
            ->where([
                ['email', '=', $email],
                ['email_verified_at', '=', null]
            ])
            ->update([
                'email_verified_at' => now()
            ]);
        if ($updated === 1) {
            DB::commit();
            return true;
        }

        DB::rollBack();
        return false;
    }
}
