<?php

namespace lockscreen\FilamentLockscreen\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LockerTimer
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle($request, Closure $next)
    {
        if ($request->method() === 'GET' && $request->session()->get('locker_last_activity') && (time() - $request->session()->get('locker_last_activity')) > config('filament-lockscreen.activity_timeout', 0)) {
            $request->session()->put('lockscreen', true);
        }

        $request->session()->put('locker_last_activity', time());

        return $next($request);
    }
}
