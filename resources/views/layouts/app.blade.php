<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>SCIENCE AU LYCEE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Important pour mobile -->
  <link rel="icon" type="image/jpeg" href="{{ asset('images/lycee.jpeg') }}">
  <!-- Favicon -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/lycee.jpeg') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
      <span>SCIENCE O LYCEE</span>
    </a>


            <!-- Liens -->
            <div class="ms-auto">
                <a href="{{ route('register') }}" class="btn btn-outline-primary me-2">Inscription</a>
                <a href="{{ route('login') }}" class="btn btn-primary">Connexion</a>
            </div>
        </div>
    </nav>

    <!-- CONTENU -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-light py-4 mt-5">
  <div class="container text-center">

    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-3">
      <!-- Facebook -->
      <a href="https://www.facebook.com/profile.php?id=61552124691149" target="_blank" class="text-light text-decoration-none">
        <i class="bi bi-facebook fs-4"></i> Facebook
      </a>
      <!-- YouTube -->
      <a href="https://www.youtube.com/@MathsPhysique_ChimieAuLycee" target="_blank" class="text-light text-decoration-none">
        <i class="bi bi-youtube fs-4"></i> YouTube
      </a>
      <!-- WhatsApp -->
      <a href="https://chat.whatsapp.com/IfV8Jmubu9Y40lkJPxp7Ob" target="_blank" class="text-light text-decoration-none">
        <i class="bi bi-whatsapp fs-4"></i> WhatsApp
      </a>
    </div>

    <p class="mt-3 mb-0">SCIENCE O LYCEE - Tous droits réservés</p>
  </div>
</footer>

<!-- Bootstrap icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</body>
</html>
