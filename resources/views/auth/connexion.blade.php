<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Plateforme Maths</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #e0e7ff 0%, #fff 100%); }
        .logo-maths { font-size: 3rem; color: #0d6efd; }
        .card { border-radius: 1rem; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow p-4">
                <div class="text-center mb-4">
                    <span class="logo-maths">
                        <i class="bi bi-calculator"></i>
                    </span>
                    <h2 class="mt-2">Connexion à la plateforme Maths</h2>
                    <p class="text-muted">Accède à tes cours, exercices et ressources en mathématiques.</p>
                </div>

                {{-- Message d'erreur --}}
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Message de succès --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="text-decoration-none">
                        <i class="bi bi-person-plus"></i> Pas encore inscrit ? Crée un compte
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
