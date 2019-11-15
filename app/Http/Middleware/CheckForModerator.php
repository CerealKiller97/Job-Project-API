<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckForModerator
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user->role->name !== 'Moderator') {
            return response()->json(['message' => 'You dont have privileges to do this action'], 403);
        }
        return $next($request);
    }
}
