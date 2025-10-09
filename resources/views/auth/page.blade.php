<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <h5 class="alert-heading mb-1">Paiement enregistré avec succès !</h5>
                    <p class="mb-0">{{ session('success') }}</p>
                    <div class="mt-2">
                        <a href="{{ route('attente') }}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-clock-history"></i> Voir mes paiements en attente
                        </a>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <h5 class="alert-heading mb-1">Erreur !</h5>
                    <p class="mb-0">{{ session('error') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="text-center mb-4">
        <span class="cours-icon"><i class="bi bi-journal-bookmark"></i></span>
        Cours disponibles
    </h2>
    <p class="text-center text-muted mb-5">
        Découvre nos chapitres de mathématiques, illustrés et interactifs.<br>
        <span class="text-primary">Clique sur "Acheter" pour accéder au contenu complet.</span>
    </p>

    @php($preview = true) {{-- Forcer l'accès test via le bouton Accéder --}}
    <div class="row">
        @forelse(($chapters ?? []) as $c)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="{{ asset('images/complexes.jpeg') }}" class="card-img-top" alt="Cours">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-2">
                            <i class="bi bi-book"></i> {{ $c->title ?? ('Chapitre #'.$c->id) }}
                        </h6>
                        <p class="card-text text-muted small">
                            Concepts clés, exercices et exemples pour progresser.
                        </p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            @if(in_array($c->id, $paidChapterIds ?? []))
                                <a href="{{ route('chapitre.show', [$c->id]) }}" class="btn btn-success">
                                    <i class="bi bi-unlock"></i> Accéder au cours
                                </a>
                            @elseif(in_array($c->id, $pendingChapterIds ?? []))
                                <button class="btn btn-warning" disabled>
                                    <i class="bi bi-clock-history"></i> Paiement en attente
                                </button>
                                <a href="{{ route('attente') }}" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-eye"></i> Voir le statut
                                </a>
                            @else
                                <a href="{{ route('paiement', ['chapter' => $c->id]) }}" class="btn btn-primary btn-buy">
                                    <i class="bi bi-cart"></i> Acheter
                                </a>
                                <a href="{{ route('chapitre.show', [$c->id, 'test'=>1]) }}" class="btn btn-outline-success">
                                    <i class="bi bi-unlock"></i> Accéder (test)
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">Aucun chapitre disponible pour le moment.</div>
        @endforelse
    </div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
