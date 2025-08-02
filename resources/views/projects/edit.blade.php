@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center text-md-start">
            <h5 class="mb-0">Modifier le projet</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom du projet</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $project->name }}" required placeholder="Entrez le nom du projet">
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="(Facultatif) Décrivez le projet...">{{ $project->description }}</textarea>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary w-100 w-md-auto">← Annuler</a>
                    <button type="submit" class="btn btn-success w-100 w-md-auto">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection