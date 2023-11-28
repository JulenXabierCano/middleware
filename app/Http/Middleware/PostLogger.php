<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PostLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $response = $next($request);

            $users = DB::table('users')->get();
            $usuarios = [];
            foreach ($users as $user) {
                $usuarios[] = $user->Usuario;
            }

            Log::info('Test funciona correctamente después | Usuarios de la bbdd: ' . implode(', ', $usuarios));
            Log::info('##############################');
            return $response;
        } catch (\Exception $e) {
            Log::error('Error en el middleware: ' . $e->getMessage());
            return response('Error en el middleware ' . $e->getMessage(), 500);
        }
    }
}
