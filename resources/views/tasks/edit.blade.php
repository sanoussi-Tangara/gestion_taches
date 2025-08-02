@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Modifier la tâche</h3>
    <form action="{{ route('tasks.update', [$projectId, $moduleId, $task->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ $task->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select name="status" id="status" class="form-select">
                <option value="en_attente" {{ $task->status == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="en_cours" {{ $task->status == 'en_cours' ? 'selected' : '' }}>En cours</option>
                <option value="complété" {{ $task->status == 'complété' ? 'selected' : '' }}>Complété</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('projects.show', $projectId) }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection