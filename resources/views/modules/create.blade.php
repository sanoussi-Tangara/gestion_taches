@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-center text-md-start">
                Créer un Module pour le projet : "{{ $project->name }}"
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('modules.store', ['projectId' => $project->id]) }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nom du Module</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Entrez le nom du module">
                </div>

                <div class="form-group mb-4">
                    <label for="description" class="form-label">Description du Module</label>
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="(Facultatif) Description du module..."></textarea>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary w-100 w-md-auto">
                        ← Retour au projet
                    </a>
                    <button type="submit" class="btn btn-success w-100 w-md-auto">
                        Enregistrer le module
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection