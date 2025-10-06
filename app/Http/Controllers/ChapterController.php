<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Paiement;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    // show chapter only if user has an approved paiement
    public function show(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);

        $paid = \App\Models\Paiement::where('user_id', auth()->id())
            ->where('chapter_id', $id)
            ->where('statut', 'approuve')->exists();

        // Mode preview/test: autoriser l'accès sans achat si:
        // - paramètre ?test=1 présent
        // - session admin active
        // - environnement local (développement)
        $preview = $request->boolean('test') || (session('admin') === true) || app()->environment('local');

        if (!$paid && !$preview) {
            return redirect()->route('paiement')->with('error','Accès réservé — paiement requis ou en attente.');
        }

        return view('chapters.show', compact('chapter'));
    }

    // admin uploads video file for a chapter
    public function uploadVideo(Request $request, $id)
    {
        $request->validate(['video' => 'required|mimes:mp4,mov,avi|max:200000']); // max ~200MB
        $chapter = Chapter::findOrFail($id);

        $file = $request->file('video');
        $filename = 'chapter_'.$id.'_video_'.time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('chapitres'), $filename);

        // Save path in DB
        $chapter->update(['video' => $filename]);

        return back()->with('success','Vidéo uploadée.');
    }

    // Admin: créer un chapitre
    public function adminStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf'   => 'nullable|mimes:pdf|max:20480', // ~20MB
            'video' => 'nullable|mimes:mp4,mov,avi|max:200000', // ~200MB
        ]);

        $data = ['title' => $request->input('title')];

        // dossier public/chapitres
        $dest = public_path('chapitres');
        if (!is_dir($dest)) { @mkdir($dest, 0775, true); }

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $name = 'chapter_pdf_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dest, $name);
            $data['pdf'] = $name;
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $name = 'chapter_video_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dest, $name);
            $data['video'] = $name;
        }

        Chapter::create($data);
        return back()->with('success', 'Chapitre créé.');
    }

    // Admin: mettre à jour un chapitre
    public function adminUpdate(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf'   => 'nullable|mimes:pdf|max:20480',
            'video' => 'nullable|mimes:mp4,mov,avi|max:200000',
        ]);

        $data = ['title' => $request->input('title')];
        $dest = public_path('chapitres');
        if (!is_dir($dest)) { @mkdir($dest, 0775, true); }

        if ($request->hasFile('pdf')) {
            // supprimer ancien
            if (!empty($chapter->pdf) && file_exists($dest.DIRECTORY_SEPARATOR.$chapter->pdf)) {
                @unlink($dest.DIRECTORY_SEPARATOR.$chapter->pdf);
            }
            $file = $request->file('pdf');
            $name = 'chapter_pdf_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dest, $name);
            $data['pdf'] = $name;
        }

        if ($request->hasFile('video')) {
            if (!empty($chapter->video) && file_exists($dest.DIRECTORY_SEPARATOR.$chapter->video)) {
                @unlink($dest.DIRECTORY_SEPARATOR.$chapter->video);
            }
            $file = $request->file('video');
            $name = 'chapter_video_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($dest, $name);
            $data['video'] = $name;
        }

        $chapter->update($data);
        return back()->with('success', 'Chapitre mis à jour.');
    }

    // Admin: supprimer un chapitre
    public function adminDestroy($id)
    {
        $chapter = Chapter::findOrFail($id);
        $dest = public_path('chapitres');
        if (!empty($chapter->pdf) && file_exists($dest.DIRECTORY_SEPARATOR.$chapter->pdf)) {
            @unlink($dest.DIRECTORY_SEPARATOR.$chapter->pdf);
        }
        if (!empty($chapter->video) && file_exists($dest.DIRECTORY_SEPARATOR.$chapter->video)) {
            @unlink($dest.DIRECTORY_SEPARATOR.$chapter->video);
        }
        $chapter->delete();
        return back()->with('success', 'Chapitre supprimé.');
    }
}
