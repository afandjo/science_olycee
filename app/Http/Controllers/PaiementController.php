<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Chapter;
use App\Mail\NewPaiementNotification;
use Illuminate\Support\Facades\Mail;

class PaiementController extends Controller
{
    // Afficher les chapitres à payer
    public function index()
    {
        $chapters = Chapter::orderBy('id')->get();
        return view('auth.paiement', compact('chapters'));
    }

    // Stocker un paiement lorsque l'utilisateur clique sur "J'ai payé"
    public function store(Request $request)
    {
        $request->validate([
            'methode'    => 'required|string',
            'numero'     => 'required|string',
            'chapter_id' => 'required|integer|exists:chapters,id',
        ]);

        $paiement = Paiement::create([
            'user_id'    => auth()->id(),
            'chapter_id' => $request->chapter_id,
            'methode'    => $request->methode,
            'numero'     => $request->numero,
            'montant'    => 5000,
            'statut'     => 'en_attente',
        ]);

        // Notification admin par email
        Mail::to('tekorolandafandjo94@gmail.com')->send(new NewPaiementNotification($paiement));

        // Vérifier si un paiement approuvé existe déjà pour ce chapitre
        $paiementValide = Paiement::where('user_id', auth()->id())
                                   ->where('chapter_id', $request->chapter_id)
                                   ->where('statut', 'approuve')
                                   ->first();

        if ($paiementValide) {
            // Rediriger vers la page du chapitre si paiement approuvé
            return redirect()->route('chapitre.show', $request->chapter_id)
                             ->with('success', 'Paiement validé, vous pouvez lire le cours.');
        }

        // Sinon, rediriger vers la page attente
        return redirect('auth/attente')
                 ->with('success', 'Demande enregistrée — en attente de validation.');
    }

    // Approuver un paiement (admin)
    public function approuver($id)
    {
        $p = Paiement::findOrFail($id);
        $p->update(['statut' => 'approuve']);
        return back()->with('success', 'Paiement approuvé.');
    }

    // Rejeter un paiement (admin)
    public function rejeter($id)
    {
        $p = Paiement::findOrFail($id);
        $p->update(['statut' => 'rejete']);
        return back()->with('success', 'Paiement rejeté.');
    }

    // Paiements validés par chapitre (admin)
    public function valides($chapitre)
    {
        $paiements = Paiement::with('user','chapter')
            ->where('chapter_id', $chapitre)
            ->where('statut', 'approuve')
            ->get();

        return view('admin.paiements.valides', compact('paiements', 'chapitre'));
    }

    // Paiements en attente (admin)
    public function attente()
    {
        $paiements = Paiement::with('user','chapter')
            ->where('statut', 'en_attente')
            ->get();

        return view('admin.paiements.attente', compact('paiements'));
    }

    // Compter les paiements approuvés par chapitre
    public function countByChapter()
    {
        return Paiement::selectRaw('chapter_id, COUNT(*) as total')
            ->where('statut', 'approuve')
            ->groupBy('chapter_id')
            ->pluck('total', 'chapter_id');
    }

    public function attent()
{
    return view('paiement.attente'); // Assure-toi que la vue existe
}

}
