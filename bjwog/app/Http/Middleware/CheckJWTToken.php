<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Redis;

class CheckJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $jwt_token = $request->header('token');

        if(!$jwt_token){
            return http_err(403);
        }

        // //解密
        JWT::$leeway = 60;
        try {
            $decoded = JWT::decode($jwt_token, JWT_TOKEN_KEY, ['HS256']);
            $arr = (array)$decoded;

        } catch (\Exception $e) {
            return http_err(403);
        }
        
        if ($arr['exp'] < time()) {
            return http_err(403);
        } else {
            $redis_key = "jwt_token_".((array)$arr['data'])['usercode'];
            if(!Redis::get($redis_key)){
                return http_err(403);
            }
        }
        return $next($request);
    }
}
