@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }

    .project-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .project-card:hover {
        transform: scale(1.02);
    }

    .btn-custom {
        background-color: #4CAF50;
        color: white;
        border-radius: 50px;
        padding: 10px 20px;
    }

    .btn-custom:hover {
        background-color: #45a049;
    }

    @media (max-width: 768px) {
        .project-card .btn {
            display: block;
            width: 100%;
            margin-bottom: 5px;
        }

        .btn-custom {
            width: 100%;
            text-align: center;
        }

        .card-body {
            text-align: center;
        }
    }
</style>

<div class="container mt-4">
    <h1 class="text-center mb-4">Liste de Tous Mes Projets</h1>

    <div class="d-grid d-md-block mb-3">
        <a href="{{ route('projects.create') }}" class="btn btn-custom">
            <i class="fas fa-plus-circle"></i> Ajouter un Projet
        </a>
    </div>

    {{-- Projets actifs --}}
    <div class="row">
        @foreach ($projects as $project)
        <div class="col-md-4 col-sm-6 col-12 mb-4">
            <div class="card project-card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                    </div>

                    <div class="mt-3 d-grid gap-2">
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>

                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>

                        <form action="{{ route('projects.archive', $project->id) }}" method="POST" onsubmit="return confirm('Confirmer l’archivage ou la réactivation ?')">
                            @csrf
                            @method('PATCH')
                            <button class="btn {{ $project->archived ? 'btn-success' : 'btn-secondary' }}">
                                <i class="fas {{ $project->archived ? 'fa-undo' : 'fa-archive' }}"></i>
                                {{ $project->archived ? 'Réactiver' : 'Archiver' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Projets archivés --}}
    @if ($archivedProjects->count())
    <hr>
    <h2 class="text-center mt-5 text-muted">Projets Archivés</h2>
    <div class="row mt-4">
        @foreach ($archivedProjects as $project)
        <div class="col-md-4 col-sm-6 col-12 mb-4">
            <div class="card project-card border-secondary h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $project->name }}</h5>
                        <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                    </div>

                    <div class="mt-3 d-grid gap-2">
                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> Voir
                        </a>

                        <form action="{{ route('projects.archive', $project->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-undo"></i> Réactiver
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection