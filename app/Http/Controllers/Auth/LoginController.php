<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\LoginServiceInterface;
use App\DTO\LoginDTO;
use App\Exceptions\AccountNotVerifiedException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\IncorrectPasswordException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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
            $user = $this->loginService->login(new LoginDTO($loginRequest->validated()));
            return response()->json($user, 200);
        } catch (IncorrectPasswordException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 400);
        } catch (EntityNotFoundException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 404);
        } catch (AccountNotVerifiedException $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 400);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
