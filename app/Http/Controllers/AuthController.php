<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Affiche le formulaire d'inscription
    public function showRegister()
    {
        return view('auth.inscription');
    }

    // Traite l'inscription
    public function register(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'pays' => 'required|string|max:100',
        'telephone' => 'required|string|max:20',
        'password' => 'required|min:6|confirmed',
    ]);

    User::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'pays' => $request->pays,
        'telephone' => $request->telephone,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('connexion')->with('success', 'Compte créé avec succès. Veuillez vous connecter.');
}

    // Affiche le formulaire de connexion
    public function showLogin()
{
    return view('auth.connexion');
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('auth.page')->with('success', 'Connexion réussie ✅');
    }

    return back()->withErrors([
        'email' => 'Adresse email ou mot de passe incorrect ❌',
    ]);
}


    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Déconnecté avec succès.');
    }



    

}
