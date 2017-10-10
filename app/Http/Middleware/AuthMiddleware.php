<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Libraries\Error;

class AuthMiddleware
{

    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {

        if (empty($guards)) {
            return $this->auth->authenticate();
        }

        foreach ($guards as $guard) {

            if ($this->auth->guard($guard)->check()) {
                return $next($request);
            }
        }

        $result = Error::make(1);
        $result['logined'] = false;
        return response()->json($result);


    }
}
