<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;



class Permissions 
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

        
        $value = session('is_admin');

        if($value == false){

            return redirect('/home');
        }
        
        return $next($request);
    }

    
}
