@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #e0e7ff 0%, #fff 100%); }
        .sidebar { background: #fff; min-height: 100vh; }
        .dashboard-icon { font-size: 2.5rem; color: #0d6efd; }
        .card { border-radius: 1rem; }
        .sidebar-logo { display: flex; flex-direction: column; align-items: center; margin-bottom: 2rem; }
        .sidebar-logo img { width: 60px; height: 60px; border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .sidebar-logo span { margin-top: 0.5rem; font-weight: bold; font-size: 1.1rem; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar avec logo -->
        <div class="col-md-2 sidebar shadow-sm py-4">
            <div class="sidebar-logo">
                <img src="{{ asset('images/lycee.jpeg') }}" alt="Logo">
                <span>Science Olycee</span>
            </div>
            <h5 class="mb-4 text-center"><i class="bi bi-speedometer2"></i> Tableau de bord</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link {{ ($tab ?? 'overview') === 'overview' ? 'active' : '' }}" href="{{ route('admin.home', ['tab'=>'overview']) }}"><i class="bi bi-house"></i> Accueil</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ ($tab ?? '') === 'paiements_valides' ? 'active' : '' }}" href="{{ route('admin.home', ['tab'=>'paiements_valides']) }}"><i class="bi bi-check2-circle"></i> Paiements validés</a>
                </li>

                @php
                    $pendingList = \App\Models\Paiement::with('user','chapter')
                        ->where('statut','en_attente')->latest()->take(5)->get();
                    $pendingCount = \App\Models\Paiement::where('statut','en_attente')->count();
                @endphp
                <li class="nav-item mb-2">
                    <a class="nav-link {{ ($tab ?? '') === 'paiements' ? 'active' : '' }}" href="{{ route('admin.home', ['tab'=>'paiements']) }}"><i class="bi bi-credit-card"></i> Paiements en attente</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ ($tab ?? '') === 'paiements_rejetes' ? 'active' : '' }}" href="{{ route('admin.home', ['tab'=>'paiements_rejetes']) }}"><i class="bi bi-x-circle"></i> Paiements rejetés</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ ($tab ?? '') === 'chapitres' ? 'active' : '' }}" href="{{ route('admin.home', ['tab'=>'chapitres']) }}"><i class="bi bi-journal-bookmark"></i> Chapitres</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ ($tab ?? '') === 'utilisateurs' ? 'active' : '' }}" href="{{ route('admin.home', ['tab'=>'utilisateurs']) }}"><i class="bi bi-people"></i> Utilisateurs</a>
                </li>  
                
            </ul>
        </div>
        <!-- Main dashboard -->
        <div class="col-md-10 py-4">
            <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Tableau de bord Administrateur</h2>

            @if(($tab ?? 'overview') === 'overview')
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <div class="dashboard-icon mb-2"><i class="bi bi-people"></i></div>
                                <h5 class="card-title">Utilisateurs</h5>
                                <p class="card-text fs-4">{{ $usersCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <div class="dashboard-icon mb-2"><i class="bi bi-journal-bookmark"></i></div>
                                <h5 class="card-title">Chapitres</h5>
                                <p class="card-text fs-4">{{ $chaptersCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <div class="dashboard-icon mb-2"><i class="bi bi-check2-circle text-success"></i></div>
                                <h5 class="card-title">Paiements validés</h5>
                                <p class="card-text fs-4">{{ $paiementsValides ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <div class="dashboard-icon mb-2"><i class="bi bi-clock-history text-warning"></i></div>
                                <h5 class="card-title">Paiements en attente</h5>
                                <p class="card-text fs-4">{{ $paiementsAttenteCount ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(($tab ?? '') === 'utilisateurs')
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <form method="get" action="{{ route('admin.home') }}" class="row g-2 align-items-center">
                            <input type="hidden" name="tab" value="utilisateurs">
                            <div class="col-auto">
                                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher (nom, email, pays, téléphone)">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
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
                            {{ $users->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            @elseif(($tab ?? '') === 'chapitres')
                <!-- Formulaire d'ajout de cours -->
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white">
                        <strong><i class="bi bi-plus-circle"></i> Ajouter un cours</strong>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.chapitres.store') }}" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Titre</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">PDF (optionnel)</label>
                                <input type="file" name="pdf" accept="application/pdf" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Vidéo (optionnel)</label>
                                <input type="file" name="video" accept="video/*" class="form-control">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <form method="get" action="{{ route('admin.home') }}" class="row g-2 align-items-center">
                            <input type="hidden" name="tab" value="chapitres">
                            <div class="col-auto">
                                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher un chapitre (titre)">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Titre</th>
                                        <th>PDF</th>
                                        <th>Vidéo</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($chapters = $chapters ?? collect())
                                    @forelse($chapters as $c)
                                        <tr>
                                            <td>{{ $c->id }}</td>
                                            <td>{{ $c->title }}</td>
                                            <td>
                                                @if(!empty($c->pdf))
                                                    <a href="{{ asset('chapitres/'.$c->pdf) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> Ouvrir</a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($c->video))
                                                    <a href="{{ asset('chapitres/'.$c->video) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-play-btn"></i> Voir</a>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <details>
                                                    <summary class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Éditer</summary>
                                                    <div class="mt-2">
                                                        <form method="post" action="{{ route('admin.chapitres.update', $c->id) }}" enctype="multipart/form-data" class="row g-2 text-start">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="col-md-5">
                                                                <input type="text" name="title" value="{{ $c->title }}" class="form-control form-control-sm" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="file" name="pdf" accept="application/pdf" class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="file" name="video" accept="video/*" class="form-control form-control-sm">
                                                            </div>
                                                            <div class="col-md-1 d-grid">
                                                                <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-check2"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </details>

                                                <form method="post" action="{{ route('admin.chapitres.destroy', $c->id) }}" class="d-inline" onsubmit="return confirm('Supprimer ce chapitre ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Aucun chapitre trouvé.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($chapters instanceof \Illuminate\Contracts\Pagination\Paginator || $chapters instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-white">
                            {{ $chapters->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            @elseif(($tab ?? '') === 'paiements')
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <form method="get" action="{{ route('admin.home') }}" class="row g-2 align-items-center">
                            <input type="hidden" name="tab" value="paiements">
                            <div class="col-auto">
                                <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher (utilisateur, chapitre)">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Utilisateur</th>
                                        <th>Chapitre</th>
                                        <th>Méthode</th>
                                        <th>Numéro</th>
                                        <th>Montant</th>
                                        <th>Référence</th>
                                        <th>Reçu</th>
                                        <th>Date</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paiementsAttente as $paiement)
                                        <tr>
                                            <td>{{ $paiement->id }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $paiement->user->nom }} {{ $paiement->user->prenom }}</strong><br>
                                                    <small class="text-muted">{{ $paiement->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $paiement->chapter->title }}</td>
                                            <td>
                                                <span class="badge bg-{{ $paiement->methode === 'T-Money' ? 'warning' : 'success' }}">
                                                    {{ $paiement->methode }}
                                                </span>
                                            </td>
                                            <td>{{ $paiement->numero }}</td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} F</td>
                                            <td>
                                                <small class="text-muted">{{ $paiement->reference ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @if($paiement->receipt)
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#receiptModal{{ $paiement->id }}">
                                                        <i class="bi bi-image"></i> Voir
                                                    </button>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <form method="post" action="{{ route('admin.paiements.approuver', $paiement->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" 
                                                                onclick="return confirm('Approuver ce paiement ?')">
                                                            <i class="bi bi-check-circle"></i> Approuver
                                                        </button>
                                                    </form>
                                                    <form method="post" action="{{ route('admin.paiements.rejeter', $paiement->id) }}" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Rejeter ce paiement ?')">
                                                            <i class="bi bi-x-circle"></i> Rejeter
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted py-4">Aucun paiement en attente.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($paiementsAttente instanceof \Illuminate\Contracts\Pagination\Paginator || $paiementsAttente instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="card-footer bg-white">
                            {{ $paiementsAttente->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            @elseif(($tab ?? '') === 'paiements_valides')
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-check2-circle text-success"></i> Paiements validés</h5>
                            <form method="get" action="{{ route('admin.home') }}" class="row g-2 align-items-center">
                                <input type="hidden" name="tab" value="paiements_valides">
                                <div class="col-auto">
                                    <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher (utilisateur, chapitre)">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Utilisateur</th>
                                        <th>Chapitre</th>
                                        <th>Méthode</th>
                                        <th>Montant</th>
                                        <th>Date validation</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paiementsValidesList ?? [] as $paiement)
                                        <tr>
                                            <td>{{ $paiement->id }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $paiement->user->nom }} {{ $paiement->user->prenom }}</strong><br>
                                                    <small class="text-muted">{{ $paiement->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $paiement->chapter->title }}</td>
                                            <td>
                                                <span class="badge bg-{{ $paiement->methode === 'T-Money' ? 'warning' : 'success' }}">
                                                    {{ $paiement->methode }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} F</td>
                                            <td>{{ $paiement->updated_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-info" onclick="showCommentModal({{ $paiement->id }}, '{{ $paiement->comment ?? '' }}')">
                                                    <i class="bi bi-chat-text"></i> Commentaire
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">Aucun paiement validé.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(isset($paiementsValidesList) && $paiementsValidesList instanceof \Illuminate\Contracts\Pagination\Paginator)
                        <div class="card-footer bg-white">
                            {{ $paiementsValidesList->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            @elseif(($tab ?? '') === 'paiements_rejetes')
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-x-circle text-danger"></i> Paiements rejetés</h5>
                            <form method="get" action="{{ route('admin.home') }}" class="row g-2 align-items-center">
                                <input type="hidden" name="tab" value="paiements_rejetes">
                                <div class="col-auto">
                                    <input type="search" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Rechercher (utilisateur, chapitre)">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Utilisateur</th>
                                        <th>Chapitre</th>
                                        <th>Méthode</th>
                                        <th>Montant</th>
                                        <th>Date rejet</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paiementsRejetesList ?? [] as $paiement)
                                        <tr>
                                            <td>{{ $paiement->id }}</td>
                                            <td>
                                                <div>
                                                    <strong>{{ $paiement->user->nom }} {{ $paiement->user->prenom }}</strong><br>
                                                    <small class="text-muted">{{ $paiement->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $paiement->chapter->title }}</td>
                                            <td>
                                                <span class="badge bg-{{ $paiement->methode === 'T-Money' ? 'warning' : 'success' }}">
                                                    {{ $paiement->methode }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} F</td>
                                            <td>{{ $paiement->updated_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-end">
                                                <button type="button" class="btn btn-sm btn-outline-info" onclick="showCommentModal({{ $paiement->id }}, '{{ $paiement->comment ?? '' }}')">
                                                    <i class="bi bi-chat-text"></i> Commentaire
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">Aucun paiement rejeté.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(isset($paiementsRejetesList) && $paiementsRejetesList instanceof \Illuminate\Contracts\Pagination\Paginator)
                        <div class="card-footer bg-white">
                            {{ $paiementsRejetesList->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modales pour afficher les reçus -->
@if(($tab ?? '') === 'paiements')
    @foreach($paiementsAttente as $paiement)
        @if($paiement->receipt)
            <!-- Modal pour le reçu -->
            <div class="modal fade" id="receiptModal{{ $paiement->id }}" tabindex="-1" aria-labelledby="receiptModalLabel{{ $paiement->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="receiptModalLabel{{ $paiement->id }}">
                                Reçu de paiement - {{ $paiement->user->nom }} {{ $paiement->user->prenom }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <div class="mb-3">
                                <strong>Chapitre:</strong> {{ $paiement->chapter->title }}<br>
                                <strong>Méthode:</strong> {{ $paiement->methode }}<br>
                                <strong>Numéro:</strong> {{ $paiement->numero }}<br>
                                <strong>Montant:</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} F<br>
                                <strong>Référence:</strong> {{ $paiement->reference ?? 'N/A' }}<br>
                                <strong>Date:</strong> {{ $paiement->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="border rounded p-2">
                                <img src="{{ Storage::url($paiement->receipt) }}" 
                                     class="img-fluid" 
                                     alt="Reçu de paiement"
                                     style="max-height: 500px; cursor: pointer;"
                                     onclick="window.open('{{ Storage::url($paiement->receipt) }}', '_blank')"
                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vbiBkaXNwb25pYmxlPC90ZXh0Pjwvc3ZnPg=='">
                            </div>
                            <p class="text-muted mt-2 small">Cliquez sur l'image pour l'ouvrir en grand</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <a href="{{ Storage::url($paiement->receipt) }}" target="_blank" class="btn btn-primary">
                                <i class="bi bi-download"></i> Ouvrir en grand
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif

<!-- Modal pour les commentaires -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Ajouter un commentaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="commentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Commentaire</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Ajoutez un commentaire sur ce paiement..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showCommentModal(paiementId, currentComment = '') {
    document.getElementById('comment').value = currentComment;
    document.getElementById('commentForm').action = `/admin/paiements/${paiementId}/comment`;
    new bootstrap.Modal(document.getElementById('commentModal')).show();
}
</script>
</body>
</html>
