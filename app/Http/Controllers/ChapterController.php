<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Paiement;
use Illuminate\Support\Facades\Storage;

class ChapterController extends Controller
{
    // show chapter only if user has an approved paiement
    public function show($id)
    {
        $chapter = Chapter::findOrFail($id);

        $paid = \App\Models\Paiement::where('user_id', auth()->id())
            ->where('chapter_id', $id)
            ->where('statut', 'approuve')->exists();

        if (!$paid) {
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
}
