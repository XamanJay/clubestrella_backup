<?php

namespace App\Http\Middleware;

use Closure;
use App;

class cliente
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
        if($request->user()->rol->nombre == 'Empleado')
        {
            return redirect()->route('not-authorized',App::getLocale()); 
        }
        
        return $next($request);
    }
}
