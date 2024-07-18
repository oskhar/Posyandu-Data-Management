<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubmissionStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $response = $next($request);

        if ($user) {
            if ($user->isAdmin()) {
                $response->setData(collect($response->original)->except('user_submitted'));
            } else {
                $response->setData($response->original);
            }
        } else {
            $response->setData(collect($response->original)->except('user_submitted'));
        }

        return $response;
    }
}
