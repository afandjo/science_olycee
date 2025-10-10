@extends('admin.login.nav')

@section('content')
<div class="container mt-4">

    <!-- Bouton retour -->
    <a href="{{ route('admin.home') }}" class="btn btn-secondary mb-3">← Retour aux chapitres</a>

    <!-- Titre avec nombre de paiements -->
    <h3 class="mb-4">⏳ Paiements en attente ({{ $paiements->count() }})</h3>

    @if($paiements->isEmpty())
        <div class="alert alert-info">
            Aucun paiement en attente pour le moment.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-warning">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Montant</th>
                        <th>Chapitre</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $p)
                    <tr>
                        <td>{{ $p->user->nom ?? '---' }}</td>
                        <td>{{ $p->user->prenom ?? '---' }}</td>
                        <td>{{ $p->user->email ?? '---' }}</td>
                        <td>{{ number_format($p->montant ?? 5000, 0, ',', ' ') }} F</td>
                        <td>Chapitre {{ $p->chapter->id ?? '---' }}</td>
                        <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <form action="{{ route('paiements.approuver', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm mb-1">Approuver</button>
                            </form>
                            <form action="{{ route('paiements.rejeter', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm mb-1">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
