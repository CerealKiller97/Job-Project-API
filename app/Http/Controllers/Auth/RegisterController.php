<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\RegisterServiceInterface;
use App\DTO\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Exception;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $registerService;

    public function __construct(RegisterServiceInterface $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(RegisterRequest $request): Response
    {
        try {
            $this->registerService->register(new RegisterDTO($request->validated()));
            return  response()->json(['message' => 'Successfully registered.'], 201);
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
