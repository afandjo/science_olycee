@extends('admin.login.nav')

@section('title', 'Modifier le chapitre')

@section('content')
<div class="container mt-5">
    <h3 class="text-center mb-4">✏️ Modifier {{ $chapter->title }}</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.chapitres.update', $chapter->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">PDF du chapitre</label>
            <input type="file" name="pdf" class="form-control" accept=".pdf">
            @if($chapter->pdf)
                <p class="mt-2">📄 Actuel : {{ $chapter->pdf }}</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Vidéo du chapitre (MP4, MOV, MPEG - Max 100MB)</label>
            <input type="file" name="video" class="form-control" accept="video/mp4,video/quicktime,video/mpeg">
            @if($chapter->video)
                <p class="mt-2">🎥 Actuelle : {{ $chapter->video }}</p>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        
    </form>
</div>
@endsection
