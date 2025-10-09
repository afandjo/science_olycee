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
            'receipt' => 'required|file|image|max:2048', // 2MB max, image only
        ]);

        // Handle file upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $fileName = time() . '_' . auth()->id() . '_' . $file->getClientOriginalName();
            $receiptPath = $file->storeAs('receipts', $fileName, 'public');
        }

        $paiement = Paiement::create([
            'user_id' => auth()->id(),
            'chapter_id' => $request->chapter_id,
            'methode' => $request->methode,
            'numero'  => $request->numero,
            'montant' => 10000,
            'statut'  => 'en_attente',
            'receipt' => $receiptPath, // Store the receipt path
            'reference' => 'PAY_' . auth()->id() . '_' . time() . '_' . $request->chapter_id,
        ]);

        // notify admin by email
        Mail::to('tekorolandafandjo9@gmail.com')->send(new NewPaiementNotification($paiement));

        return redirect()->route('auth.page')->with('success','✅ Paiement envoyé avec succès ! Votre reçu a été transmis à l\'administrateur pour validation. Vous recevrez une notification dès que votre accès sera confirmé.');
    }


    // Admin approve / reject
    public function approuver($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->update(['statut'=>'approuve']);
        return redirect()->back()->with('success','Paiement approuvé avec succès ✅');
    }

    public function rejeter($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->update(['statut'=>'rejete']);
        return redirect()->back()->with('success','Paiement rejeté avec succès ✅');
    }
    public function valides($chapitre)
{
    $paiements = \App\Models\Paiement::with('user','chapter')
        ->where('chapter_id', $chapitre)
        ->where('statut', 'approuve') // ✅ correction
        ->get();

    return view('admin.paiements.valides', compact('paiements', 'chapitre'));
}

public function attente()
{
    $paiements = \App\Models\Paiement::with('user','chapter')
        ->where('user_id', auth()->id()) // ✅ Filtrer par utilisateur connecté
        ->where('statut', 'en_attente')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('auth.attente', compact('paiements'));
}

public function countByChapter()
{
    return \App\Models\Paiement::selectRaw('chapter_id, COUNT(*) as total')
        ->where('statut', 'approuve') // ✅ correction
        ->groupBy('chapter_id')
        ->pluck('total', 'chapter_id');
}

public function updateComment(Request $request, $id)
{
    $paiement = Paiement::findOrFail($id);
    $paiement->update(['comment' => $request->comment]);
    return redirect()->back()->with('success','Commentaire ajouté avec succès ✅');
}

}
