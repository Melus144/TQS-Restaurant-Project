<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->user()->role !== User::ADMINISTRATOR && auth()->user()->role > $role) {
            return response(null, ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
