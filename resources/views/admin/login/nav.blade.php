<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Science Olycee</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Important pour mobile -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/lycee.jpeg') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
      <span>Science Olycee</span>
    </a>

    <!-- Bouton hamburger pour mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav ms-auto">
        <!-- Validés avec chapitres -->
        <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
    Validés
  </a>
  <ul class="dropdown-menu">
    @for($i=1; $i<=10; $i++)
      <li>
        <a class="dropdown-item" href="{{ route('paiements.valides', $i) }}">
          Chapitre {{ $i }} 
          <span class="badge bg-success">
            {{ $counts[$i] ?? 0 }}
          </span>
        </a>
      </li>
    @endfor
  </ul>
</li>


        <!-- En attente -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('paiements.attente') }}">En attente</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Contenu -->
<div class="container mt-4">
  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
