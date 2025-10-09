<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // <-- toujours ici, pas à l'intérieur de la classe
use App\Models\Paiement;
use App\Models\Chapter;

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
    public function index(Request $request)
    {
        if (!session('admin')) {
            return redirect()->route('admin.connexion')->with('error', 'Veuillez vous connecter d’abord.');
        }

        $tab = $request->get('tab', 'overview');

        $users = collect();
        $usersCount = User::count();
        $chaptersCount = Chapter::count();
        $paiementsValides = Paiement::where('statut', 'approuve')->count();
        $paiementsAttenteCount = Paiement::where('statut', 'en_attente')->count();
        $revenuTotal = Paiement::where('statut', 'approuve')->sum('montant');
        $paiementsRecents = collect();
        $chapters = collect(); // éviter compact() variable indéfinie
        $paiementsAttente = collect(); // pour la liste des paiements en attente
        $paiementsValidesList = collect(); // pour la liste des paiements validés
        $paiementsRejetesList = collect(); // pour la liste des paiements rejetés

        if ($tab === 'overview') {
            $paiementsRecents = Paiement::with('user','chapter')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();
        } elseif ($tab === 'utilisateurs') {
            // Liste des utilisateurs avec recherche et pagination
            $query = User::query();
            $search = $request->get('q');
            if ($search) {
                $query->where(function($q) use ($search){
                    $q->where('nom','like',"%{$search}%")
                      ->orWhere('prenom','like',"%{$search}%")
                      ->orWhere('email','like',"%{$search}%")
                      ->orWhere('pays','like',"%{$search}%")
                      ->orWhere('telephone','like',"%{$search}%");
                });
            }
            $users = $query->orderByDesc('created_at')->paginate(10)->appends(['tab' => 'utilisateurs', 'q' => $search]);
        } elseif ($tab === 'chapitres') {
            // Liste des chapitres avec recherche par titre et pagination
            $cQuery = Chapter::query();
            $cSearch = $request->get('q');
            if ($cSearch) {
                $cQuery->where('title', 'like', "%{$cSearch}%");
            }
            $chapters = $cQuery->orderBy('id')->paginate(10)->appends(['tab' => 'chapitres', 'q' => $cSearch]);
        } elseif ($tab === 'paiements') {
            // Liste des paiements en attente avec recherche et pagination
            $pQuery = Paiement::with('user', 'chapter')
                ->where('statut', 'en_attente');
            $pSearch = $request->get('q');
            if ($pSearch) {
                $pQuery->whereHas('user', function($q) use ($pSearch) {
                    $q->where('nom', 'like', "%{$pSearch}%")
                      ->orWhere('prenom', 'like', "%{$pSearch}%")
                      ->orWhere('email', 'like', "%{$pSearch}%");
                })->orWhereHas('chapter', function($q) use ($pSearch) {
                    $q->where('title', 'like', "%{$pSearch}%");
                });
            }
            $paiementsAttente = $pQuery->orderByDesc('created_at')->paginate(10)->appends(['tab' => 'paiements', 'q' => $pSearch]);
        } elseif ($tab === 'paiements_valides') {
            // Liste des paiements validés avec recherche et pagination
            $pQuery = Paiement::with('user', 'chapter')
                ->where('statut', 'approuve');
            $pSearch = $request->get('q');
            if ($pSearch) {
                $pQuery->whereHas('user', function($q) use ($pSearch) {
                    $q->where('nom', 'like', "%{$pSearch}%")
                      ->orWhere('prenom', 'like', "%{$pSearch}%")
                      ->orWhere('email', 'like', "%{$pSearch}%");
                })->orWhereHas('chapter', function($q) use ($pSearch) {
                    $q->where('title', 'like', "%{$pSearch}%");
                });
            }
            $paiementsValidesList = $pQuery->orderByDesc('updated_at')->paginate(10)->appends(['tab' => 'paiements_valides', 'q' => $pSearch]);
        } elseif ($tab === 'paiements_rejetes') {
            // Liste des paiements rejetés avec recherche et pagination
            $pQuery = Paiement::with('user', 'chapter')
                ->where('statut', 'rejete');
            $pSearch = $request->get('q');
            if ($pSearch) {
                $pQuery->whereHas('user', function($q) use ($pSearch) {
                    $q->where('nom', 'like', "%{$pSearch}%")
                      ->orWhere('prenom', 'like', "%{$pSearch}%")
                      ->orWhere('email', 'like', "%{$pSearch}%");
                })->orWhereHas('chapter', function($q) use ($pSearch) {
                    $q->where('title', 'like', "%{$pSearch}%");
                });
            }
            $paiementsRejetesList = $pQuery->orderByDesc('updated_at')->paginate(10)->appends(['tab' => 'paiements_rejetes', 'q' => $pSearch]);
        }

        return view('admin.home', compact(
            'tab',
            'users',
            'usersCount',
            'chaptersCount',
            'paiementsValides',
            'paiementsAttenteCount',
            'revenuTotal',
            'paiementsRecents',
            'chapters',
            'paiementsAttente',
            'paiementsValidesList',
            'paiementsRejetesList'
        ));
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

        $user->update($request->only(['nom','prenom','email','pays','telephone']));

        return redirect()->route('admin.home')->with('success', 'Utilisateur mis à jour avec succès ✅');
    }

    // Déconnexion admin
    public function logout()
    {
        session()->forget('admin'); // Supprime la session admin
        return redirect()->route('admin.connexion')->with('success', 'Vous êtes déconnecté avec succès ✅');
    }

    // Liste des utilisateurs (admin)
    public function users(Request $request)
    {
        if (!session('admin')) {
            return redirect()->route('admin.connexion')->with('error', 'Veuillez vous connecter d’abord.');
        }

        $query = User::query();

        if ($search = $request->get('q')) {
            $query->where(function($q) use ($search){
                $q->where('nom','like',"%{$search}%")
                  ->orWhere('prenom','like',"%{$search}%")
                  ->orWhere('email','like',"%{$search}%")
                  ->orWhere('pays','like',"%{$search}%")
                  ->orWhere('telephone','like',"%{$search}%");
            });
        }

        $users = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('admin.utilisateurs', compact('users'));
    }
}
