<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Plateforme Maths</title>
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
        <div class="col-md-7">
            <div class="card shadow p-4">
                <div class="text-center mb-4">
                    <span class="logo-maths">
                        <i class="bi bi-pencil-square"></i>
                    </span>
                    <h2 class="mt-2">Inscription à la plateforme Maths</h2>
                    <p class="text-muted">Rejoins-nous pour accéder à des cours, exercices et ressources en mathématiques adaptés à ton niveau.</p>
                </div>

                {{-- Messages d'erreur --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pays</label>
                            <input type="text" name="pays" class="form-control" value="{{ old('pays') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Niveau scolaire</label>
                        <select name="niveau" class="form-select" required>
                            <option value="">Sélectionne ton niveau</option>
                            <option value="college" {{ old('niveau') == 'college' ? 'selected' : '' }}>Collège</option>
                            <option value="lycee" {{ old('niveau') == 'lycee' ? 'selected' : '' }}>Lycée</option>
                            <option value="universite" {{ old('niveau') == 'universite' ? 'selected' : '' }}>Université</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-person-plus me-2"></i>S'inscrire
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="bi bi-box-arrow-in-right"></i> Déjà inscrit ? Connecte-toi ici
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
