<?php

namespace App\Http\Middleware;

use Closure;
use App;

class supervisor
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
        if($request->user()->rol->nombre == 'Cliente' || $request->user()->rol->nombre == 'Empleado')
        {
            return back()->with('privileges','No cuentas con los permisos necesarios para realizar esta acción'); 
        }
        
        return $next($request);
    }
}
