<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>SCIENCE AU LYCEE</title>


  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Important pour mobile -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- ✅ Favicon -->
  <link rel="icon" type="image/jpeg" href="{{ asset('images/lycee.jpeg') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
      .navbar-brand span {
          text-transform: uppercase; /* Force le texte en majuscules */
          font-weight: bold;
      }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/lycee.jpeg') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
      <span>SCIENCE AU LYCEE</span>
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
                  <span class="badge bg-success">{{ $counts[$i] ?? 0 }}</span>
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
