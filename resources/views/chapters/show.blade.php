<!doctype html><html lang="fr"><head><meta charset="utf-8"><title>{{ $chapter->title }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<style>canvas{width:100%!important;border-bottom:1px solid #ccc;} .no-download{user-select:none;}</style>
</head><body class="bg-light">
<div class="container mt-5">
  <h2>{{ $chapter->title }}</h2>

  @if($chapter->pdf)
  <div class="card mb-4 p-3">
    <h5>Lecture PDF</h5>
    <p class="text-muted">Lecture en ligne uniquement — téléchargement désactivé</p>
    <canvas id="pdf-canvas"></canvas>
  </div>
  @else
    <p class="text-muted">PDF non disponible pour ce chapitre.</p>
  @endif

  <div class="card p-3">
    <h5>Vidéo</h5>
    @if($chapter->video)
      <video controls playsinline style="width:100%" controlsList="nodownload">
        <source src="{{ asset('chapitres/'.$chapter->video) }}" type="video/mp4">
        Votre navigateur ne supporte pas la lecture de la vidéo.
      </video>
    @else
      <p class="text-muted">Vidéo non ajoutée par l'administrateur.</p>
    @endif
  </div>
</div>

<script>
@if($chapter->pdf)
const url = "{{ asset('chapitres/'.$chapter->pdf) }}";
const canvas = document.getElementById('pdf-canvas');
const ctx = canvas.getContext('2d');
pdfjsLib.getDocument(url).promise.then(pdf => {
    pdf.getPage(1).then(page => {
        const viewport = page.getViewport({scale:1.2});
        canvas.height = viewport.height;
        canvas.width  = viewport.width;
        page.render({canvasContext:ctx, viewport:viewport});
    });
});
@endif

// disable right click & selection
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('keydown', e => {
  // block Ctrl+S, Ctrl+U, Ctrl+Shift+I
  if ((e.ctrlKey && e.key==='s') || (e.ctrlKey && e.key==='u') || (e.ctrlKey && e.shiftKey && e.key==='I')) e.preventDefault();
});
</script>
</body></html>
