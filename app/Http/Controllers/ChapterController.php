<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;

class ChapterController extends Controller
{
    // Affiche le chapitre avec PDF et vidéo
    public function show($id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('chapitre.show', compact('chapter'));
    }

    // Affichage sécurisé du PDF
    public function pdf($id)
    {
        $chapter = Chapter::findOrFail($id);

        if (!$chapter->pdf) {
            abort(404, "PDF non trouvé pour ce chapitre.");
        }

        // ✅ Correction du bon chemin
        $path = storage_path('app/public/chapitres/'.$chapter->pdf);

        if (!file_exists($path)) {
            abort(404, "Fichier PDF introuvable.");
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="'.$chapter->pdf.'"'
        ]);
    }

    // Liste des chapitres pour l'admin
    public function index()
    {
        $chapters = Chapter::all();
        return view('admin.chapitres.index', compact('chapters'));
    }

    // Page d'édition d'un chapitre
    public function edit($id)
    {
        $chapter = Chapter::findOrFail($id);
        return view('admin.chapitres.edit', compact('chapter'));
    }

    // Mise à jour du PDF et/ou vidéo
    public function update(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);

        $request->validate([
            'pdf' => 'nullable|mimes:pdf|max:20480',
            'video' => 'nullable|mimetypes:video/mp4|max:51200'
        ]);

        if ($request->hasFile('pdf')) {
            $pdfName = 'chapitre' . $id . '.' . $request->file('pdf')->getClientOriginalExtension();
            $request->file('pdf')->storeAs('public/chapitres', $pdfName);
            $chapter->pdf = $pdfName;
        }

        if ($request->hasFile('video')) {
            $videoName = 'chapitre' . $id . '.' . $request->file('video')->getClientOriginalExtension();
            $request->file('video')->storeAs('public/chapitres', $videoName);
            $chapter->video = $videoName;
        }

        $chapter->save();

        return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre mis à jour avec succès ✅');
    }
}
