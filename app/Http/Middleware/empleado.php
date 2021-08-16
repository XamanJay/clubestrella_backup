<?php

namespace App\Http\Middleware;

use Closure;
use App;

class empleado
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
        if($request->user()->rol->nombre == 'Cliente')
        {
            return redirect()->route('no-authorized',App::getLocale()); 
        }
        
        return $next($request);
    }
}
