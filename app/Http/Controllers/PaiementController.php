<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Chapter;
use App\Mail\NewPaiementNotification;
use Illuminate\Support\Facades\Mail;

class PaiementController extends Controller
{
    public function index()
    {
        $chapters = Chapter::orderBy('id')->get(); // 1..10
        return view('auth.paiement', compact('chapters'));
    }

    // store when user clicks "J'ai payé" (hidden inputs filled by payer link)
    public function store(Request $request)
    {
        $request->validate([
            'methode' => 'required|string',
            'numero'  => 'required|string',
            'chapter_id' => 'required|integer|exists:chapters,id',
        ]);

        $paiement = Paiement::create([
            'user_id' => auth()->id(),
            'chapter_id' => $request->chapter_id,
            'methode' => $request->methode,
            'numero'  => $request->numero,
            'montant' => 10000,
            'statut'  => 'en_attente',
        ]);

        // notify admin by email
        Mail::to('tekorolandafandjo9@gmail.com')->send(new NewPaiementNotification($paiement));

        return redirect()->route('attente')->with('success','Demande enregistrée — en attente de validation.');
    }

    public function attente(){ return view('auth.attente'); }

    // Admin approve / reject
    public function approuver($id)
    {
        $p = Paiement::findOrFail($id);
        $p->update(['statut'=>'approuve']);
        return back()->with('success','Paiement approuvé.');
    }

    public function rejeter($id)
    {
        $p = Paiement::findOrFail($id);
        $p->update(['statut'=>'rejete']);
        return back()->with('success','Paiement rejeté.');
    }
}
