<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Attribute;

#[Attribute]
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        if (!in_array(Auth::user()?->tipeUser, $roles)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}

