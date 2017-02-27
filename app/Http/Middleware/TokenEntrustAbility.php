<?php
namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class TokenEntrustAbility extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles, $permissions, $validateAll = false)
    {
        if(!$request->user()->ability(explode('|', $roles), explode('|', $permissions), array('validate_all' => $validateAll))) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', 401, 'Unauthorized');
        }

        $user = $request->input('user');

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}