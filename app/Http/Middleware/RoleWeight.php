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


        //假設自行設置的$weight裡，不包含使用者身分數字
        if (!str_contains($weight, strval($userRole))){

            // 若身分是管理員
            if($userRole == '1'){
                return redirect(route('dashboard'));
            }
            // 身分不是管理員
            return redirect(route('index'));
        }
        return $next($request);
    }
}


