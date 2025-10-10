@extends('admin.login.nav')

@section('content')
<div class="container mt-4">

    <!-- Bouton retour -->
    <a href="{{ route('admin.home') }}" class="btn btn-secondary mb-3">← Retour aux chapitres</a>

    <!-- Titre avec nombre de paiements -->
    <h3 class="mb-4">✅ Paiements validés - Chapitre {{ $chapitre }} ({{ $paiements->count() }})</h3>

    @if($paiements->isEmpty())
        <div class="alert alert-info">
            Aucun paiement validé pour ce chapitre.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $p)
                    <tr>
                        <td>{{ $p->user->nom ?? '---' }}</td>
                        <td>{{ $p->user->prenom ?? '---' }}</td>
                        <td>{{ $p->user->email ?? '---' }}</td>
                        <td>{{ number_format($p->montant ?? 5000, 0, ',', ' ') }} F</td>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
