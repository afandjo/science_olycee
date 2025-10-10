@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Cours disponibles</h2>

    <div class="row">
        @for($i = 1; $i <= 10; $i++)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ asset('images/chap' . $i . '.jpg') }}" class="card-img-top" alt="Cours Chapitre {{ $i }}">
                    <div class="card-body text-center">
                        <h6 class="card-title">Chapitre {{ $i }}</h6>
                        <a href="{{ route('paiement') }}" class="btn btn-primary mt-3">acheter</a>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

@endsection
