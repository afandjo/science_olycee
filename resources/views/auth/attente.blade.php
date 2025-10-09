<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement en attente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #e0e7ff 0%, #fff 100%); min-height: 100vh; }
        .success-card { border-left: 4px solid #28a745; }
        .waiting-card { border-left: 4px solid #ffc107; }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .container { padding: 1rem; }
            .table-responsive { font-size: 0.85rem; }
            .table th, .table td { padding: 0.5rem 0.25rem; }
            .badge { font-size: 0.7rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.8rem; }
            .card-header h5 { font-size: 1rem; }
            .alert { font-size: 0.9rem; padding: 0.75rem; }
        }
        
        @media (max-width: 576px) {
            .table th, .table td { padding: 0.25rem; font-size: 0.75rem; }
            .badge { font-size: 0.65rem; }
            .btn { padding: 0.5rem 0.75rem; font-size: 0.85rem; }
            .card-body { padding: 1rem 0.75rem; }
            .d-flex.gap-2 { gap: 0.5rem !important; }
        }
        
        /* Hide less important columns on small screens */
        @media (max-width: 768px) {
            .hide-mobile { display: none; }
        }
        
        @media (max-width: 576px) {
            .hide-mobile-sm { display: none; }
        }
        
        /* Mobile card improvements */
        @media (max-width: 768px) {
            .card.border-warning {
                border-width: 2px !important;
            }
            .card-body {
                padding: 1rem;
            }
            .gap-1 {
                gap: 0.25rem !important;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid py-3 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            @if(session('success'))
                <div class="alert alert-success success-card alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-check-circle-fill me-2 me-md-3 flex-shrink-0" style="font-size: 1.25rem; margin-top: 0.125rem;"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1" style="font-size: 1rem;">Paiement enregistré avec succès !</h5>
                            <p class="mb-2 mb-md-0" style="font-size: 0.9rem;">{{ session('success') }}</p>
                            <div class="mt-2">
                                <a href="{{ route('attente') }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-clock-history"></i> <span class="d-none d-sm-inline">Voir mes paiements en attente</span>
                                    <span class="d-sm-none">Mes paiements</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 me-md-3 flex-shrink-0" style="font-size: 1.25rem; margin-top: 0.125rem;"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1" style="font-size: 1rem;">Erreur !</h5>
                            <p class="mb-0" style="font-size: 0.9rem;">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($paiements->count() > 0)
                <!-- Liste des paiements en attente -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Mes paiements en attente ({{ $paiements->count() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        <!-- Desktop Table View -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Chapitre</th>
                                        <th>Méthode</th>
                                        <th>Numéro</th>
                                        <th>Montant</th>
                                        <th class="hide-mobile">Référence</th>
                                        <th>Date d'envoi</th>
                                        <th>Reçu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paiements as $paiement)
                                        <tr>
                                            <td>
                                                <strong>{{ $paiement->chapter->title ?? 'Chapitre #' . $paiement->chapter_id }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $paiement->methode === 'T-Money' ? 'warning' : 'success' }}">
                                                    {{ $paiement->methode }}
                                                </span>
                                            </td>
                                            <td>{{ $paiement->numero }}</td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} F</td>
                                            <td class="hide-mobile">
                                                <small class="text-muted">{{ $paiement->reference ?? 'N/A' }}</small>
                                            </td>
                                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($paiement->receipt)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle"></i> Envoyé
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle"></i> Manquant
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="d-md-none">
                            @foreach($paiements as $paiement)
                                <div class="card mb-3 border-warning">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="card-title mb-2">
                                                    <strong>{{ $paiement->chapter->title ?? 'Chapitre #' . $paiement->chapter_id }}</strong>
                                                </h6>
                                                <div class="d-flex flex-wrap gap-1 mb-2">
                                                    <span class="badge bg-{{ $paiement->methode === 'T-Money' ? 'warning' : 'success' }}">
                                                        {{ $paiement->methode }}
                                                    </span>
                                                    @if($paiement->receipt)
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle"></i> Reçu
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="bi bi-x-circle"></i> Manquant
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="text-primary fw-bold">{{ number_format($paiement->montant, 0, ',', ' ') }} F</div>
                                                <small class="text-muted">{{ $paiement->created_at->format('d/m H:i') }}</small>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <small class="text-muted">Numéro:</small><br>
                                                <strong>{{ $paiement->numero }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Référence:</small><br>
                                                <small class="text-muted">{{ $paiement->reference ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Message informatif -->
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Information :</strong> Vos paiements sont en cours de validation par l'administrateur. 
                    Vous recevrez une notification par email dès que votre accès sera confirmé.
                </div>
            @else
                <!-- Aucun paiement en attente -->
                <div class="card waiting-card shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="card-title mb-3">Aucun paiement en attente</h3>
                        <p class="card-text text-muted mb-4">
                            Vous n'avez actuellement aucun paiement en cours de validation.
                        </p>
                        <div class="alert alert-success d-inline-block">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Astuce :</strong> Vous pouvez acheter de nouveaux chapitres pour accéder au contenu.
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('auth.page') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-left"></i> 
                    <span class="d-none d-sm-inline">Retour aux chapitres</span>
                    <span class="d-sm-none">Retour</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
