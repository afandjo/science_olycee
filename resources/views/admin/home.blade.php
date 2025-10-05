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
                    <a class="nav-link active" href="#"><i class="bi bi-house"></i> Accueil</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="bi bi-check2-circle"></i> Paiements validés</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="bi bi-clock-history"></i> Paiements en attente</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="bi bi-x-circle"></i> Paiements rejetés</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#"><i class="bi bi-journal-bookmark"></i> Chapitres</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('admin.utilisateurs') }}">
                        <i class="bi bi-people"></i> Utilisateurs
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main dashboard -->
        <div class="col-md-10 py-4">
            <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Tableau de bord Administrateur</h2>
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
                            <p class="card-text fs-4">{{ $paiementsAttente ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ajoute ici d'autres statistiques ou graphiques si besoin -->
        </div>
    </div>
</div>
</body>
</html>
