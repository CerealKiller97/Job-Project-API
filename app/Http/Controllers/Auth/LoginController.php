<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\LoginServiceInterface;
use App\DTO\Login;
use App\Exceptions\{AccountNotVerifiedException, IncorrectPasswordException};
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * @var LoginServiceInterface
     */
    private $loginService;

    public function __construct(LoginServiceInterface $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * @param  LoginRequest  $loginRequest
     * @return Response
     */
    public function login(LoginRequest $loginRequest): Response
    {
        try {
            $login = new Login($loginRequest->validated());
            $user = $this->loginService->login($login);
            return response()->json($user, 200);
        } catch (IncorrectPasswordException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 400);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => "User not found."], 404);
        } catch (AccountNotVerifiedException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 409);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
