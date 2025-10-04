@extends('admin.login.nav')

@section('content')
<div class="container mt-4">
    <h3>⏳ Paiements en attente</h3>

    @if($paiements->isEmpty())
        <p>Aucun paiement en attente.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Chapitre</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $p)
                <tr>
                    <td>{{ $p->user->nom ?? '---' }}</td>
                    <td>{{ $p->user->prenom ?? '---' }}</td>
                    <td>{{ $p->user->email ?? '---' }}</td>
                    <td>Chapitre {{ $p->chapter->id ?? '?' }}</td>
                    <td>{{ $p->montant ?? '10 000' }} F</td>
                    <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.paiements.approuver', $p->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Valider</button>
                        </form>
                        <form action="{{ route('admin.paiements.rejeter', $p->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Rejeter</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
