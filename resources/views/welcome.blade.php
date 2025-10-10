@extends('layouts.app')

@section('title', 'Cours de Mathématiques')

@section('content')

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-size: cover;
        background-position: center;
        transition: background-image 1s ease-in-out;
    }

    main {
        flex: 1; /* prend tout l'espace restant */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        grid-gap: 30px;
        max-width: 1000px;
        width: 100%;
        margin-bottom: 50px;
    }

    .grid-item {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        font-size: 1.2rem;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .grid-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.3);
    }

    /* Formulaire */
    .contact-form {
        max-width: 600px;
        width: 100%;
        background: rgba(255,255,255,0.9);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        margin-bottom: 50px;
    }
</style>

<main>
    <div class="grid-container">
        <div class="grid-item">📚 Révise tes chapitres de mathématiques facilement</div>
        <div class="grid-item">🧮 Résous des exercices et comprends les concepts</div>
        <div class="grid-item">✏️ Suis les cours en ligne et des tutoriels</div>
        <div class="grid-item">🎯 Prépare-toi pour les examens et concours</div>
    </div>

    <div class="contact-form">
        <h3 class="text-center mb-4">💬 Envoyer nous des commentaires</h3>

        <form action="mailto:tekorolandafandjo94@gmail.com" method="post" enctype="text/plain">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="Nom" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="Email" required>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Commentaire</label>
                <textarea class="form-control" id="message" name="Message" rows="5" required></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </form>
    </div>
</main>

<script>
    const images = ['mat.png', 'math.png', 'mathe.png'];
    let index = 0;

    function changeBackground() {
        document.body.style.backgroundImage = `url('{{ asset('images/') }}/${images[index]}')`;
        index = (index + 1) % images.length;
    }

    changeBackground();
    setInterval(changeBackground, 5000);
</script>

@endsection
