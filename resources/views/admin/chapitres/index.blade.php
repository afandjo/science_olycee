@extends('admin.login.nav')

@section('title', 'Gestion des chapitres')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">📘 Gestion des chapitres</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>PDF</th>
                <th>Vidéo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chapters as $chapter)
                <tr>
                    <td>{{ $chapter->id }}</td>
                    <td>{{ $chapter->title }}</td>
                    <td>
                        @if($chapter->pdf)
                            ✅
                        @else
                            ❌
                        @endif
                    </td>
                    <td>
                        @if($chapter->video)
                            🎥
                        @else
                            ❌
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.chapitres.edit', $chapter->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
