<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;
use App\Models\User; // <-- toujours ici, pas à l'intérieur de la classe

class AdminController extends Controller
{
    // Affiche le formulaire de connexion admin
    public function showLogin()
    {
        return view('admin.connexion');
    }

    // Traite la connexion admin
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Identifiants fixes
        $adminEmail = 'math@gmail.com';
        $adminPassword = '12345678';

        if ($request->email === $adminEmail && $request->password === $adminPassword) {
            // Session admin
            session(['admin' => true]);
            return redirect()->route('admin.home');
        }

        return back()->with('error', 'Adresse mail ou mot de passe incorrect ❌');
    }

    // Page admin
    public function index()
{
    if (!session('admin')) {
        return redirect()->route('admin.connexion')->with('error', 'Veuillez vous connecter d’abord.');
    }

    $users = User::all();
    $counts = $this->getCountsByChapter(); // <-- ajouter ça
    return view('admin.home', compact('users', 'counts'));
}

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.home')->with('success', 'Utilisateur supprimé avec succès ✅');
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    // Mettre à jour l'utilisateur
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'pays' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.home')->with('success', 'Utilisateur mis à jour avec succès ✅');
    }

    public function logout()
{
    session()->forget('admin'); // Supprime la session admin
    return redirect()->route('admin.connexion')->with('success', 'Vous êtes déconnecté avec succès ✅');
}

public function getCountsByChapter()
{
    // Renvoie un tableau chapter_id => total paiements approuvés
    return Paiement::selectRaw('chapter_id, COUNT(*) as total')
        ->where('statut', 'approuve')
        ->groupBy('chapter_id')
        ->pluck('total', 'chapter_id')
        ->toArray();
}

}
