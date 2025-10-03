<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Cours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Cours disponibles</h2>

    <div class="row">
        @for($i = 1; $i <= 10; $i++)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ asset('images/complexes.jpeg') }}" class="card-img-top" alt="Cours">
                    <div class="card-body text-center">
                        <h6 class="card-title">Chapitre {{ $i }}</h6>
                        <a href="{{ route('paiement') }}" class="btn btn-primary mt-3">Voir plus</a>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

</body>
</html>
