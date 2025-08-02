@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-center text-md-start">Modifier le module</h5>
        </div>

        <div class="card-body">
            <form action="{{ route('modules.update', [$projectId, $module->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom du module</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $module->name }}" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description (facultatif)</label>
                    <textarea name="description" id="description" class="form-control" rows="4">{{ $module->description }}</textarea>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                    <a href="{{ route('projects.show', $projectId) }}" class="btn btn-secondary w-100 w-md-auto">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-success w-100 w-md-auto">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection