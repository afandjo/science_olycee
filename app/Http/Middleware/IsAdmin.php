<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Autoriser si admin connecté via session custom
        if (session('admin') === true) {
            return $next($request);
        }

        // Ou via un utilisateur authentifié portant le flag is_admin
        if (auth()->check() && (property_exists(auth()->user(), 'is_admin') ? auth()->user()->is_admin : false)) {
            return $next($request);
        }

        return redirect()->route('admin.connexion')->with('error', 'Accès réservé aux administrateurs.');
    }
}
