<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class TokenEntrustRole extends BaseMiddleware
{
    const DELIMETER = '|';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if(!is_array($roles)){
            $roles = explode(self::DELIMETER,$roles);
        }

        if(!$request->user()->hasRole($roles)){
            return $this->respond('tymon.jwt.invalid', 'token_invalid', 401, 'Unauthorized');
        }

        return $next($request);
    }
}
