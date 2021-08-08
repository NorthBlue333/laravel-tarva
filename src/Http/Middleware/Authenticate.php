<?php

namespace LaravelTarva\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        $middleware = config('laravel-tarva.auth.middleware');

        if(config($middleware)) {
            try {
                (new $middleware($this->auth))->handle($request, $next, $guards);
            } catch (AuthenticationException $exception) {
                throw new AuthenticationException(
                    $exception->getMessage(), $exception->guards(), $this->redirectTo($request)
                );
            }
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('laravel-tarva::login');
        }
    }
}
