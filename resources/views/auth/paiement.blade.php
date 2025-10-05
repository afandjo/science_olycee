<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Paiement chapitres</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-center">Choisissez un chapitre à payer (10.000 F)</h2>

  <div class="row">
    @foreach($chapters as $chapter)
      <div class="col-md-3 mb-4">
        <div class="card shadow-sm">
          <img src="{{ asset('images/complexes.jpeg') }}" class="card-img-top" alt="chapitre">
          <div class="card-body text-center">
            <h6 class="card-title">{{ $chapter->title }}</h6> <!-- ✅ Correction ici -->
           
            <!-- T-Money -->
            <a href="tel:*145*1*1*91399753*10000%23"
               class="btn btn-warning btn-sm m-1"
               onclick="setPayment({{ $chapter->id }}, 'T-Money', '91399753')">T-Money</a>

            <!-- Flooz -->
            <a href="tel:*155*1*1*97370739*10000%23"
               class="btn btn-success btn-sm m-1"
               onclick="setPayment({{ $chapter->id }}, 'Flooz', '97370739')">Flooz</a>

            <form action="{{ route('paiement.store') }}" method="POST" id="pay-form-{{ $chapter->id }}">
              @csrf
              <input type="hidden" name="methode" id="methode-{{ $chapter->id }}">
              <input type="hidden" name="numero"  id="numero-{{ $chapter->id }}">
              <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
              <button type="submit" class="btn btn-primary btn-sm mt-2">J'ai payé</button>
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
</script>

</body>
</html>
