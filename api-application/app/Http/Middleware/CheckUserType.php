<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $user = Auth::user();

        if ($type === 'admin' && $user instanceof \App\Models\AdminModel) {
            return $next($request);
        }

        if ($type === 'user' && $user instanceof \App\Models\UserModel) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
