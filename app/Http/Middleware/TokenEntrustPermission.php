<?php

namespace App\Http\Middleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

use Closure;

class TokenEntrustPermission extends BaseMiddleware
{
    const DELIMETER = '|';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {
        if (!is_array($permissions)) {
            $permissions = explode(self::DELIMETER, $permissions);
        }

        if(!$request->user()->can($permissions)){
            return $this->respond('tymon.jwt.invalid', 'token_invalid', 401, 'Unauthorized');
        }

        return $next($request);
    }
}
