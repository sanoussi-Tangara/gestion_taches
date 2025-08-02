@extends('layouts.app')

@section('content')
<div class="container form-container">
    <h2 class="text-center mb-4">Ajouter un Nouveau Projet</h2>
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom du Projet</label>
            <input type="text" class="form-control" id="name" name="name" required placeholder="Entrez le nom du projet">
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Description du Projet</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="(Facultatif) Décrivez votre projet..."></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-custom">
                <i class="fas fa-save me-2"></i> Sauvegarder
            </button>
        </div>
    </form>
</div>

<!-- Styles adaptés mobile -->
<style>
    .form-container {
        max-width: 100%;
        width: 100%;
        margin: 30px auto;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    @media (min-width: 576px) {
        .form-container {
            max-width: 600px;
        }
    }

    .btn-custom {
        background-color: #4CAF50;
        color: white;
        border-radius: 50px;
        padding: 10px 20px;
        font-weight: 500;
    }

    .btn-custom:hover {
        background-color: #45a049;
    }
</style>
@endsection