<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

class Permission
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
        $name = Route::currentRouteName();
        $arr=explode('.',$name);
        $data=$arr['0'].'.'.$arr['1'];
        if (Gate::allows('permission', $data)) {
            return $next($request);
        }else{
            abort('403');
        }
    }
}
