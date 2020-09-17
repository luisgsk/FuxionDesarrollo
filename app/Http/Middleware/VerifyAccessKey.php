<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccessKey
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
        //Si el request es setlog/
        if ($request->is('setlog/*')) {
            // Obtenemos el api-key que el usuario envia
            $key = $request->headers->get('api_key');
            // Si coincide con el valor almacenado en la aplicacion
            // la aplicacion se sigue ejecutando
            if (isset($key) && $key === env('API_KEY')) {
                return $next($request);
            } else {
                // Si falla devolvemos el mensaje de error
                return response()->json(['error' => 'unauthorized'], 401);
            }
        } //
        else {
            //De resto retorno la app
            return $next($request);
        }
    }
}
