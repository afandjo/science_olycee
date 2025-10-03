<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Cours de Mathématiques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container text-center mt-5">
        <h1 class="mb-4">📘 Bienvenue sur la plateforme des cours de Mathématiques</h1>
        <p class="lead">Apprends, révise et télécharge tes cours de maths en toute simplicité.</p>

        <div class="mt-5">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mx-2">📝 S’inscrire</a>
            <a href="{{ route('login') }}" class="btn btn-success btn-lg mx-2">🔑 Se connecter</a>
        </div>
    </div>

</body>
</html>
