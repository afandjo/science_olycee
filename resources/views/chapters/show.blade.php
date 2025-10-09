<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $chapter->title }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
  <style>
    canvas{width:100%!important;border-bottom:1px solid #ccc;}
    .no-download{user-select:none;}
  </style>
  </head>
<body class="bg-light">
<div class="container py-4 py-md-5">
  <h2 class="h4 h-md-3 mb-4">{{ $chapter->title }}</h2>

  @if($chapter->pdf)
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Lecture PDF</h5>
      <p class="text-muted small mb-3">Lecture en ligne uniquement — téléchargement désactivé</p>
      <canvas id="pdf-canvas"></canvas>
    </div>
  </div>
  @else
    <p class="text-muted">PDF non disponible pour ce chapitre.</p>
  @endif

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Vidéo</h5>
      @if($chapter->video)
        <div class="ratio ratio-16x9">
          <video controls playsinline class="w-100" controlsList="nodownload">
            <source src="{{ asset('chapitres/'.$chapter->video) }}" type="video/mp4">
            Votre navigateur ne supporte pas la lecture de la vidéo.
          </video>
        </div>
      @else
        <p class="text-muted">Vidéo non ajoutée par l'administrateur.</p>
      @endif
    </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
