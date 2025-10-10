@extends('layouts.app')

@section('title', 'Paiement des chapitres')

@section('content')
<div class="container mt-5">

  <h2 class="mb-4 text-center fw-bold">📘 Paiement des chapitres de mathématiques (5000 F CFA)</h2>

  <!-- ✅ Tableau récapitulatif des paiements -->
  <div class="card shadow-sm mb-5">
    <div class="card-header bg-dark text-white text-center">
      <h5>💰 Vos paiements récents</h5>
    </div>
    <div class="card-body">
      @php
        $paiementsUser = \App\Models\Paiement::with('chapter')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
      @endphp

      @if($paiementsUser->isEmpty())
        <p class="text-center text-muted">Aucun paiement effectué pour le moment.</p>
      @else
        <div class="table-responsive">
          <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>Chapitre</th>
                <th>Méthode</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($paiementsUser as $p)
                <tr>
                  <td>{{ $p->chapter->titre ?? 'Chapitre supprimé' }}</td>
                  <td>{{ $p->methode }}</td>
                  <td>{{ number_format($p->montant, 0, ',', ' ') }} F</td>
                  <td>
                    @if($p->statut === 'approuve')
                      <span class="badge bg-success">✅ Validé</span>
                    @elseif($p->statut === 'en_attente')
                      <span class="badge bg-warning text-dark">⏳ En attente</span>
                    @else
                      <span class="badge bg-danger">❌ Rejeté</span>
                    @endif
                  </td>
                  <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>

  <!-- ✅ Liste des chapitres à payer -->
  <div class="row">
    @foreach($chapters as $chapter)
      @php
        $paiement = \App\Models\Paiement::where('user_id', auth()->id())
                      ->where('chapter_id', $chapter->id)
                      ->latest()
                      ->first();
      @endphp

      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card shadow-sm chapter-card" id="chapter-{{ $chapter->id }}">
          <img src="{{ asset('images/chap' . $chapter->id . '.jpg') }}" class="card-img-top" alt="Cours {{ $chapter->titre }}">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold">{{ $chapter->titre }}</h6>

            @if(!$paiement)
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

            @elseif($paiement->statut === 'en_attente')
              <button class="btn btn-secondary btn-sm mt-2" disabled>En attente de validation ⏳</button>

            @elseif($paiement->statut === 'approuve')
              <a href="{{ route('chapitre.show', $chapter->id) }}" class="btn btn-success btn-sm mt-2">
                ✅ Paiement validé — Voir le cours
              </a>

            @elseif($paiement->statut === 'rejete')
              <small class="text-danger d-block mb-2">Paiement rejeté ❌</small>
              <a href="tel:*145*1*1*91399753*10000%23"
                 class="btn btn-warning btn-sm m-1"
                 onclick="setPayment({{ $chapter->id }}, 'T-Money', '91399753')">T-Money</a>

              <a href="tel:*155*1*1*97370739*10000%23"
                 class="btn btn-success btn-sm m-1"
                 onclick="setPayment({{ $chapter->id }}, 'Flooz', '97370739')">Flooz</a>

              <form action="{{ route('paiement.store') }}" method="POST" id="pay-form-{{ $chapter->id }}">
                @csrf
                <input type="hidden" name="methode" id="methode-{{ $chapter->id }}">
                <input type="hidden" name="numero"  id="numero-{{ $chapter->id }}">
                <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
                <button type="submit" class="btn btn-primary btn-sm mt-2">Refaire le paiement</button>
              </form>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- 💅 STYLE -->
<style>
.chapter-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}
.chapter-card:hover {
    transform: scale(1.05) rotate(-1deg);
    box-shadow: 0px 6px 20px rgba(0,0,0,0.3);
}
.card-header h5 {
    margin: 0;
}
</style>

<!-- ⚙️ SCRIPT -->
<script>
function setPayment(chapterId, methode, numero){
    document.getElementById('methode-'+chapterId).value = methode;
    document.getElementById('numero-'+chapterId).value  = numero;
    document.querySelectorAll('.chapter-card').forEach(card => card.classList.remove('active'));
    document.getElementById('chapter-'+chapterId).classList.add('active');
}

document.querySelectorAll('form[id^="pay-form-"]').forEach(form => {
    form.addEventListener('submit', function(e){
        const chapterId = this.querySelector('input[name="chapter_id"]').value;
        const methode = document.getElementById('methode-' + chapterId).value;
        const numero  = document.getElementById('numero-' + chapterId).value;

        if (!methode || !numero) {
            e.preventDefault();
            alert("Veuillez d'abord choisir T-Money ou Flooz avant de valider !");
        }
    });
});
</script>
@endsection
