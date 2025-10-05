<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Cours de Mathématiques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #e0e7ff 0%, #fff 100%); }
        .feature-icon { font-size: 2.5rem; color: #0d6efd; }
        .navbar-brand { font-size: 1.5rem; }
        .footer { background: #f8f9fa; padding: 1rem 0; margin-top: 3rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-calculator"></i> MathsOlycée
        </a>
        <div>
            <a href="{{ route('register') }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-pencil-square"></i> S’inscrire
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-success">
                <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </a>
        </div>
    </div>
</nav>

<div class="container text-center mt-5">
    <h1 class="mb-4">
        <i class="bi bi-book"></i> Bienvenue sur la plateforme des cours de Mathématiques
    </h1>
    <p class="lead mb-5">
        Apprends, révise et télécharge tes cours de maths en toute simplicité.<br>
        <span class="text-primary">Pour tous les niveaux : collège, lycée, université.</span>
    </p>

    <div class="row justify-content-center mb-5">
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="feature-icon mb-3"><i class="bi bi-journal-text"></i></div>
                    <h5 class="card-title">Cours interactifs</h5>
                    <p class="card-text">Accède à des leçons claires et illustrées pour progresser rapidement.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="feature-icon mb-3"><i class="bi bi-pencil"></i></div>
                    <h5 class="card-title">Exercices corrigés</h5>
                    <p class="card-text">Entraîne-toi avec des exercices variés et leurs solutions détaillées.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="feature-icon mb-3"><i class="bi bi-cloud-arrow-down"></i></div>
                    <h5 class="card-title">Téléchargements</h5>
                    <p class="card-text">Télécharge des fiches, annales et supports pour réviser hors ligne.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="feature-icon mb-3"><i class="bi bi-people"></i></div>
                    <h5 class="card-title">Forum d’entraide</h5>
                    <p class="card-text">Pose tes questions et échange avec la communauté des passionnés de maths.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg mx-2">
            <i class="bi bi-pencil-square"></i> S’inscrire
        </a>
        <a href="{{ route('login') }}" class="btn btn-success btn-lg mx-2">
            <i class="bi bi-box-arrow-in-right"></i> Se connecter
        </a>
    </div>
</div>

<footer class="footer text-center">
    <div class="container">
        <span class="me-3"><i class="bi bi-envelope"></i> contact@mathsolycee.com</span>
        <a href="#" class="me-2 text-dark"><i class="bi bi-facebook"></i></a>
        <a href="#" class="me-2 text-dark"><i class="bi bi-twitter"></i></a>
        <a href="#" class="text-dark"><i class="bi bi-instagram"></i></a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
