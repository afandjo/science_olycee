<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Cours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #e0e7ff 0%, #fff 100%); }
        .card { border-radius: 1rem; }
        .card-img-top { height: 140px; object-fit: cover; border-radius: 1rem 1rem 0 0; }
        .cours-icon { font-size: 2rem; color: #0d6efd; }
        .btn-buy { font-weight: bold; }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">
        <span class="cours-icon"><i class="bi bi-journal-bookmark"></i></span>
        Cours disponibles
    </h2>
    <p class="text-center text-muted mb-5">
        Découvre nos chapitres de mathématiques, illustrés et interactifs.<br>
        <span class="text-primary">Clique sur “Acheter” pour accéder au contenu complet.</span>
    </p>

    @php($preview = request()->boolean('test') || (session('admin') === true) || app()->environment('local'))
    <div class="row">
        @forelse(($chapters ?? []) as $c)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="{{ asset('images/complexes.jpeg') }}" class="card-img-top" alt="Cours">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-2">
                            <i class="bi bi-book"></i> {{ $c->title ?? ('Chapitre #'.$c->id) }}
                        </h6>
                        <p class="card-text text-muted small">
                            Concepts clés, exercices et exemples pour progresser.
                        </p>
                        @php($paid = in_array($c->id, $paidChapterIds ?? []))
                        @if($preview || $paid)
                            <a href="{{ $preview ? route('chapitre.show', [$c->id, 'test'=>1]) : route('chapitre.show', $c->id) }}" class="btn btn-success mt-2">
                                <i class="bi bi-unlock"></i> Accéder
                            </a>
                        @else
                            <a href="{{ route('paiement', ['chapter' => $c->id]) }}" class="btn btn-primary btn-buy mt-2">
                                <i class="bi bi-cart"></i> Acheter
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">Aucun chapitre disponible pour le moment.</div>
        @endforelse
    </div>
</div>

</body>
</html>
