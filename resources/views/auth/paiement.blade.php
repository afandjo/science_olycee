<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- ajout pour responsive -->
  <title>Paiement chapitres</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- favicon / icônes du site (tailles agrandies et icône iOS) -->
  <link rel="icon" href="{{ asset('images/lycee-removebg-preview.png') }}" type="image/jpeg" sizes="32x32">
  <link rel="icon" href="{{ asset('images/lycee-removebg-preview.png') }}" type="image/jpeg" sizes="64x64">
  <link rel="icon" href="{{ asset('images/lycee-removebg-preview.png') }}" type="image/jpeg" sizes="128x128">
  <link rel="icon" href="{{ asset('images/lycee-removebg-preview.png') }}" type="image/jpeg" sizes="192x192">
  <link rel="apple-touch-icon" href="{{ asset('images/lycee.jpeg') }}" sizes="180x180">
  <meta name="theme-color" content="#ffffff">
  <style>
    /* petites améliorations pour écran mobile */
    .card-img-top {
      height: 160px;
      object-fit: cover;
    }
    @media (max-width: 420px) {
      .card-img-top { height: 140px; }
      .card-title { font-size: 0.95rem; }
    }

    .small-note { font-size: .85rem; color: #555; }
    .receipt-input { display: none; }
    @media (max-width: 768px) {
      .receipt-input { display: block; margin-top: .5rem; }
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-4">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <div class="d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>
          <strong>Succès !</strong> {{ session('success') }}
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>
          <strong>Erreur !</strong> {{ session('error') }}
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <h2 class="mb-4 text-center fs-5">Choisissez un chapitre à payer (10.000 F)</h2>

  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
    @foreach($chapters as $chapter)
      <div class="col">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('images/complexes.jpeg') }}" class="card-img-top img-fluid" alt="chapitre">
          <div class="card-body d-flex flex-column align-items-center text-center">
            <h6 class="card-title mb-2">{{ $chapter->title }}</h6>

            <div class="d-flex flex-wrap justify-content-center gap-2 w-100">
              <!-- T-Money : on confirme l'action avant d'initier l'appel/tel -->
              <button type="button"
                      class="btn btn-warning btn-sm flex-grow-1"
                      onclick="doPayment({{ $chapter->id }}, 'T-Money', '91399753', '*145*1*1*91399753*10000%23')"
                      aria-label="Payer {{ $chapter->title }} avec T-Money">T-Money</button>

              <!-- Flooz : on confirme l'action avant d'initier l'appel/tel -->
              <button type="button"
                      class="btn btn-success btn-sm flex-grow-1"
                      onclick="doPayment({{ $chapter->id }}, 'Flooz', '97370739', '*155*1*1*97370739*10000%23')"
                      aria-label="Payer {{ $chapter->title }} avec Flooz">Flooz</button>
            </div>

            <p class="small-note mt-2 text-center">
              En cliquant sur T‑Money ou Flooz vous allez initier l'action de paiement sur votre téléphone.
              Après le paiement, revenez ici et joignez la capture d'écran du reçu en appuyant sur "J'ai payé".
            </p>

            <form action="{{ route('paiement.store') }}" method="POST" id="pay-form-{{ $chapter->id }}" class="w-100 mt-2" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="methode" id="methode-{{ $chapter->id }}">
              <input type="hidden" name="numero"  id="numero-{{ $chapter->id }}">
              <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
              <div class="receipt-input">
                <label for="receipt-{{ $chapter->id }}" class="form-label small">Joindre la capture du reçu (photo ou capture d'écran)</label>
                <input type="file" name="receipt" id="receipt-{{ $chapter->id }}" accept="image/*" class="form-control form-control-sm" required>
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-2 w-100 w-md-auto" onclick="confirmPayment({{ $chapter->id }})">J'ai payé</button>
            </form>
         
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<script>
function setPayment(chapterId, methode, numero){
    document.getElementById('methode-'+chapterId).value = methode;
    document.getElementById('numero-'+chapterId).value  = numero;
}

function doPayment(chapterId, methode, numero, telCode){
    var confirmMsg = "Vous allez initier un paiement via " + methode + ". Après paiement, revenez ici et joignez la capture du reçu dans 'J'ai payé'. Continuer ?";
    if (!confirm(confirmMsg)) return;

    // remplir les champs cachés
    setPayment(chapterId, methode, numero);

    // tenter d'ouvrir le dialer / USSD sur le téléphone (fonctionne sur mobile)
    try {
        window.location.href = "tel:" + encodeURIComponent(telCode);
    } catch(e) {
        // fallback : rien à faire
        console.warn('Impossible d\'ouvrir le dialer:', e);
    }
}

function confirmPayment(chapterId) {
    // Vérifier si les champs sont remplis
    const methode = document.getElementById('methode-'+chapterId).value;
    const numero = document.getElementById('numero-'+chapterId).value;
    const receipt = document.getElementById('receipt-'+chapterId).files[0];
    
    if (!methode || !numero) {
        alert('⚠️ Veuillez d\'abord sélectionner une méthode de paiement (T-Money ou Flooz)');
        return;
    }
    
    if (!receipt) {
        alert('⚠️ Veuillez joindre la capture du reçu de paiement');
        return;
    }
    
    // Vérifier le type de fichier
    if (!receipt.type.startsWith('image/')) {
        alert('⚠️ Veuillez sélectionner une image (JPG, PNG, etc.)');
        return;
    }
    
    // Vérifier la taille du fichier (2MB max)
    if (receipt.size > 2 * 1024 * 1024) {
        alert('⚠️ Le fichier est trop volumineux. Taille maximum : 2MB');
        return;
    }
    
    // Boîte de dialogue de confirmation
    const confirmMessage = `
📋 Confirmation d'envoi du reçu :

💰 Méthode : ${methode}
📱 Numéro : ${numero}
📄 Fichier : ${receipt.name}
📏 Taille : ${(receipt.size / 1024).toFixed(1)} KB

Êtes-vous sûr de vouloir envoyer ce reçu pour validation ?
    `;
    
    if (confirm(confirmMessage)) {
        // Afficher un indicateur de chargement
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-hourglass-split"></i> Envoi en cours...';
        button.disabled = true;
        
        // Soumettre le formulaire
        document.getElementById('pay-form-'+chapterId).submit();
        
        // Réactiver le bouton après 5 secondes (au cas où)
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 5000);
    }
}
</script>

</body>
</html>
