<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(): Response
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out.'], 200);
    }
}
