<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAssignment
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
        $obj = $request->session()->get('menu') !== null ? $request->session()->get('menu') : ['childs'=>[]];
        $routes = array_column($obj['childs'],'route');
        $pwd = $request->getPathInfo();
        if(in_array($pwd, $routes) || session('is_admin'))
            return $next($request); 
        else
            return redirect('/home');
    }
}
