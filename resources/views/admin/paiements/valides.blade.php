@extends('admin.login.nav')

@section('content')
<div class="container mt-4">
    <h3>✅ Paiements validés - Chapitre {{ $chapitre }}</h3>

    @if($paiements->isEmpty())
        <p>Aucun paiement validé pour ce chapitre.</p>
    @else
        <table class="table table-bordered table-striped">
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
                    <td>{{ $p->montant ?? '10 000' }} F</td>
                    <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
