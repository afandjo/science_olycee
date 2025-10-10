<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si la session admin est active
        if (session('admin') === true) {
            return $next($request);
        }

        // Sinon, redirige vers la page de connexion admin
        return redirect()->route('admin.login')->with('error', 'Accès réservé à l’administrateur.');
    }
}
