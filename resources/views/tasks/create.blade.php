@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Ajouter une tâche pour le module "{{ $module->name }}"</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('modules.tasks.store', [$project->id, $module->id]) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Titre de la tâche</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Statut</label>

                    <div class="btn-group" role="group" aria-label="Choix du statut">
                        <input type="radio" class="btn-check" name="status" id="status-en_attente" value="en_attente" checked>
                        <label class="btn btn-outline-danger" for="status-en_attente">
                            <i class="fas fa-clock"></i> En attente
                        </label>

                        <input type="radio" class="btn-check" name="status" id="status-en_cours" value="en_cours">
                        <label class="btn btn-outline-warning" for="status-en_cours">
                            <i class="fas fa-spinner"></i> En cours
                        </label>

                        <input type="radio" class="btn-check" name="status" id="status-complete" value="complété">
                        <label class="btn btn-outline-success" for="status-complete">
                            <i class="fas fa-check-circle"></i> Complété
                        </label>
                    </div>
                </div>


                <div class="d-flex justify-content-between">
                    <a href="{{ route('projects.show', $project->id) }}" class="btn btn-secondary">
                        ← Retour
                    </a>
                    <button type="submit" class="btn btn-success">
                        Enregistrer la tâche
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection