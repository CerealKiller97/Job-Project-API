<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function logout(): Response
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out.'], 200);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception->getMessage());
            return response()->json(['message' => 'Server error, please try again.'], 500);
        }
    }
}
