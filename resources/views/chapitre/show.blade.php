<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Chapitre : {{ $chapter->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        canvas { width: 100% !important; border-bottom: 1px solid #ccc; touch-action: pinch-zoom; }
        .no-select { user-select: none; -webkit-user-select: none; -webkit-touch-callout: none; }
        .overlay-protect { position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(255,255,255,0); pointer-events:none; z-index:5; }
        .filigrane { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%) rotate(-30deg); font-size:3rem; color: rgba(0,0,0,0.05); z-index:2; pointer-events:none; user-select:none; }
        @media (max-width: 768px) { .filigrane { font-size:2rem; } }
        #pdf-iframe { width: 100%; height: 70vh; border:0; }
        video { width: 100%; height:auto; }
    </style>
</head>
<body class="bg-light no-select">

<div class="container mt-4 position-relative">
    <h2 class="mb-3">{{ $chapter->title }}</h2>

    {{-- PDF --}}
    @if($chapter->pdf)
    <div class="card mb-4 p-3 shadow-sm position-relative">
        <div class="filigrane">PROTECTION ACTIVE</div>
        <div class="overlay-protect" id="overlay"></div>
        <h5>Lecture PDF</h5>
        <p class="text-muted small">Lecture en ligne uniquement — capture et téléchargement bloqués</p>

        <div id="pdf-viewer" class="text-center">
            <canvas id="pdf-canvas"></canvas>
            <div class="d-flex justify-content-center mt-2">
                <button id="prev" class="btn btn-secondary btn-sm mx-1">← Précédente</button>
                <span id="page-info" class="mx-2 align-self-center"></span>
                <button id="next" class="btn btn-secondary btn-sm mx-1">Suivante →</button>
                <button id="zoom-in" class="btn btn-primary btn-sm mx-1">Zoom +</button>
                <button id="zoom-out" class="btn btn-primary btn-sm mx-1">Zoom -</button>
            </div>
            <div id="pdf-fallback" class="mt-2 d-none">
                <iframe id="pdf-iframe" src="{{ route('chapitre.pdf', $chapter->id) }}"></iframe>
            </div>
            <p id="pdf-error" class="text-danger d-none mt-2">Impossible de charger le PDF via le lecteur intégré. Lecture en fallback ci-dessous.</p>
        </div>
    </div>
    @else
        <p class="text-muted">PDF non disponible pour ce chapitre.</p>
    @endif

    {{-- Vidéo --}}
    @if($chapter->video)
    <div class="card mb-4 p-3 shadow-sm">
        <h5>Vidéo</h5>
        <video controls playsinline controlsList="nodownload" style="max-width: 100%; height: auto;" preload="metadata">
            <source src="{{ route('chapitre.video', $chapter->id) }}" type="video/mp4">
            <source src="{{ route('chapitre.video', $chapter->id) }}" type="video/quicktime">
            Votre navigateur ne supporte pas la lecture de la vidéo.
        </video>
        <p class="text-muted small mt-2">📹 Fichier : {{ $chapter->video }}</p>
    </div>
    @else
        <p class="text-muted">Vidéo non ajoutée par l'administrateur.</p>
    @endif
</div>

<script>
@if($chapter->pdf)
const pdfUrl = "{{ route('chapitre.pdf', $chapter->id) }}";
console.log("URL du PDF:", pdfUrl);

const canvas = document.getElementById('pdf-canvas');
const ctx = canvas.getContext('2d');
const pageInfo = document.getElementById('page-info');
const controls = document.getElementById('pdf-viewer').querySelector('div.d-flex');
const pdfError = document.getElementById('pdf-error');
const pdfFallback = document.getElementById('pdf-fallback');

// Configuration PDF.js
if (typeof pdfjsLib === 'undefined') {
    console.error("PDF.js n'est pas chargé!");
    pdfError.classList.remove('d-none');
    pdfError.textContent = "Erreur: Bibliothèque PDF.js non chargée.";
    canvas.style.display = "none";
    controls.style.display = "none";
    pdfFallback.classList.remove('d-none');
} else {
    console.log("PDF.js chargé avec succès");
    pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
}

let pdfDoc = null, currentPage = 1, totalPages = 0, isRendering = false;
let scale = 1.2;

function renderPage(num){
    if (!pdfDoc) {
        console.error("pdfDoc n'est pas défini");
        return;
    }
    isRendering = true;
    console.log("Rendu de la page:", num);
    pdfDoc.getPage(num).then(page => {
        const viewport = page.getViewport({ scale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        page.render({ canvasContext: ctx, viewport }).promise.then(() => {
            isRendering = false;
            pageInfo.textContent = `Page ${num} / ${totalPages}`;
            console.log("Page rendue avec succès");
        });
    }).catch(err => {
        console.error("Erreur lors du rendu de la page:", err);
        isRendering = false;
    });
}

document.getElementById('prev').addEventListener('click', () => { if(currentPage>1 && !isRendering){ currentPage--; renderPage(currentPage); }});
document.getElementById('next').addEventListener('click', () => { if(currentPage<totalPages && !isRendering){ currentPage++; renderPage(currentPage); }});
document.getElementById('zoom-in').addEventListener('click', () => { scale += 0.2; renderPage(currentPage); });
document.getElementById('zoom-out').addEventListener('click', () => { if(scale>0.4){ scale -= 0.2; renderPage(currentPage); } });

// Chargement du PDF
console.log("Tentative de chargement du PDF...");
pdfjsLib.getDocument({
    url: pdfUrl,
    withCredentials: true
}).promise.then(pdf => {
    console.log("PDF chargé avec succès! Pages:", pdf.numPages);
    pdfDoc = pdf;
    totalPages = pdf.numPages;
    renderPage(currentPage);
}).catch(err => {
    console.error("Erreur lors du chargement du PDF:", err);
    pdfError.classList.remove('d-none');
    pdfError.textContent = "Erreur: " + err.message + ". Tentative de chargement en iframe...";
    canvas.style.display = "none";
    controls.style.display = "none";
    pdfFallback.classList.remove('d-none');
});

// Protection clic droit & touches
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('keydown', e => {
    if ((e.ctrlKey && ['s','S','u','U','p','P'].includes(e.key)) ||
        (e.key==='PrintScreen') ||
        (e.ctrlKey && e.shiftKey && ['I','J','C'].includes(e.key))) {
        e.preventDefault();
        alert("📚 Cette action est désactivée pour protéger le contenu.");
    }
});

// Overlay filigrane anti-capture
setInterval(() => {
    const overlay = document.getElementById('overlay');
    if (overlay) {
        overlay.style.background = `rgba(255,255,255,${Math.random()*0.05})`;
    }
}, 800);
@endif
</script>

</body>
</html>
