<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleWeight
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $weight): Response
    {
        $userRole = $request->user()?->user_role ?? 0;

        if (!str_contains($weight, strval($userRole))) {

            if ($userRole == '1') {
                return redirect(route('dashboard'));
            }

            return redirect(route('index'));
        }
        return $next($request);
    }
}
