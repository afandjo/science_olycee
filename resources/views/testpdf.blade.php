<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Chapitre : {{ $chapter->title }}</title>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
</head>
<body>

<h2>{{ $chapter->title }}</h2>

@if($chapter->pdf)
    <canvas id="pdf-canvas" style="border:1px solid #ccc; width:100%;"></canvas>
@else
    <p>PDF non disponible pour ce chapitre.</p>
@endif

<script>
@if($chapter->pdf)
const url = "{{ asset('storage/chapitres/'.$chapter->pdf) }}";
const canvas = document.getElementById('pdf-canvas');
const ctx = canvas.getContext('2d');
pdfjsLib.GlobalWorkerOptions.workerSrc = "https://mozilla.github.io/pdf.js/build/pdf.worker.js";

pdfjsLib.getDocument(url).promise.then(pdf => {
    pdf.getPage(1).then(page => {
        const viewport = page.getViewport({ scale: 1.2 });
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        page.render({ canvasContext: ctx, viewport: viewport });
    });
}).catch(err => {
    console.error('Erreur PDF.js :', err);
    canvas.insertAdjacentHTML('afterend', '<p style="color:red;">Impossible de charger le PDF.</p>');
});
@endif
</script>

</body>
</html>
