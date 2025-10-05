<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin • Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body{ background:#f8fafc; }
        .card{ border-radius: .75rem; }
    </style>
    </head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="bi bi-people"></i> Utilisateurs</h3>
        <div class="d-flex gap-2">
            <form method="get" action="{{ route('admin.utilisateurs') }}" class="d-flex" role="search">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm me-2" placeholder="Rechercher (nom, email, pays, téléphone)">
                <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('admin.home') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Dashboard</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Pays</th>
                            <th>Téléphone</th>
                            <th>Inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>{{ $u->nom }}</td>
                                <td>{{ $u->prenom }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->pays }}</td>
                                <td>{{ $u->telephone }}</td>
                                <td>{{ optional($u->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Aucun utilisateur trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users instanceof \Illuminate\Contracts\Pagination\Paginator || $users instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
</body>
</html>
