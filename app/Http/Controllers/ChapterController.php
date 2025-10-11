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

    // Affichage sécurisé de la vidéo
    public function video($id)
    {
        $chapter = Chapter::findOrFail($id);

        if (!$chapter->video) {
            abort(404, "Vidéo non trouvée pour ce chapitre.");
        }

        $path = storage_path('app/public/chapitres/'.$chapter->video);

        if (!file_exists($path)) {
            abort(404, "Fichier vidéo introuvable : " . $path);
        }

        // Déterminer le type MIME basé sur l'extension
        $extension = pathinfo($chapter->video, PATHINFO_EXTENSION);
        $mimeTypes = [
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
            'mpeg' => 'video/mpeg',
            'avi' => 'video/x-msvideo',
        ];
        $mimeType = $mimeTypes[strtolower($extension)] ?? 'video/mp4';

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.$chapter->video.'"',
            'Accept-Ranges' => 'bytes'
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
            'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime|max:102400'
        ]);

        $updated = false;

        if ($request->hasFile('pdf')) {
            $pdfFile = $request->file('pdf');
            $pdfName = 'chapitre' . $id . '.pdf';
            $pdfFile->storeAs('public/chapitres', $pdfName);
            $chapter->pdf = $pdfName;
            $updated = true;
            \Log::info("PDF uploadé: " . $pdfName);
        }

        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $extension = $videoFile->getClientOriginalExtension();
            $videoName = 'chapitre' . $id . '.' . $extension;
            $videoFile->storeAs('public/chapitres', $videoName);
            $chapter->video = $videoName;
            $updated = true;
            \Log::info("Vidéo uploadée: " . $videoName);
        }

        if ($updated) {
            $chapter->save();
            return redirect()->route('admin.chapitres.index')->with('success', 'Chapitre mis à jour avec succès ✅');
        }

        return redirect()->back()->with('info', 'Aucun fichier sélectionné.');
    }
}
