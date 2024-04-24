<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = PersonalAccessToken::findToken($request->bearerToken());
            if ($token){
                return $next($request);
            }
        } catch (\Throwable $th) {
        }
        
        return response([
            'message'=>'Chưa đang nhập'
        ],Response::HTTP_UNAUTHORIZED);
    }
}
