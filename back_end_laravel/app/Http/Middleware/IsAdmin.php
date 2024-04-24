<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class IsAdmin
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
            $tokenn = PersonalAccessToken::findToken($request->bearerToken());
            $user = $tokenn->tokenable;
            if ($user){
                if($user['role'] === 'admin'){
                    return $next($request);
                }
                else{
                    return response([
                        'message'=>'Api chỉ được sử dụng cho admin'
                    ],Response::HTTP_FORBIDDEN);
                }
            }
        } catch (\Throwable $th) {}
        
        return response([
            'message'=>'Chưa đang nhập'
        ],Response::HTTP_UNAUTHORIZED);
    }
}
