<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\LoginServiceInterface;
use App\DTO\Login;
use App\Exceptions\{AccountNotVerifiedException, EntityNotFoundException, IncorrectPasswordException};
use App\Events\UserNotActive;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class LoginService
 * @package App\Services
 */
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

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * LoginService constructor.
     * @param  Hasher  $hasher
     * @param  JWTAuth  $auth
     * @param  EventDispatcher  $dispatcher
     */
    public function __construct(Hasher $hasher, JWTAuth $auth, EventDispatcher $dispatcher)
    {
        $this->hasher = $hasher;
        $this->jwtAuth = $auth;
        $this->eventDispatcher = $dispatcher;
    }

    /**
     * @param  Login  $login
     * @return array
     * @throws AccountNotVerifiedException
     * @throws IncorrectPasswordException
     * @throws ModelNotFoundException
     * @throws Throwable
     */
    public function login(Login $login): array
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('email', '=', $login->email)->firstOrFail();

        if (!$this->hasher->check($login->password, $user->password)) {
            throw new IncorrectPasswordException();
        }

        // If we change hashing driver then we need to rehash password
        if ($this->hasher->needsRehash($user->password)) {
            $user->password = $this->hasher->make($login->password);
            $user->saveOrFail();
        }

        $token = $this->jwtAuth->fromSubject($user);

        if (!$user->hasVerifiedEmail()) {
            $this->eventDispatcher->dispatch(new UserNotActive($user));
            throw new AccountNotVerifiedException();
        }

        return [
            'token' => $token,
            'user' => new UserResource($user)
        ];
    }
}
