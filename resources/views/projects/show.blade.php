@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }

    .module-task-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .module-card,
    .task-list {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s ease;
        width: 100%;
    }

    .module-card:hover,
    .task-list:hover {
        transform: scale(1.02);
    }

    @media (min-width: 768px) {
        .module-card {
            width: 48%;
        }

        .task-list {
            width: 48%;
        }
    }

    .task-status {
        padding: 5px 10px;
        border-radius: 5px;
        color: white;
    }

    .task-status.en-cours {
        background-color: #ffc107;
    }

    .task-status.complété {
        background-color: #28a745;
    }

    .task-status.en-attente {
        background-color: #dc3545;
    }
</style>

<div class="container mt-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
    @endif

    <h1 class="text-center mb-4">{{ $project->name }}</h1>
    <p class="text-center">{{ $project->description }}</p>

    <!-- Upload Cahier de Charges -->
    @if(!$project->archived)
    <div class="my-4">
        <h4><i class="fas fa-file-upload"></i> Importer le Cahier de Charges (PDF)</h4>

        <form action="{{ route('specifications.store', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="pdf_file" accept="application/pdf" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i> Importer le PDF
            </button>
        </form>
    </div>
    @endif

    <!-- MWB Upload -->
    @if(!$project->archived)
    <div class="my-4">
        <form action="{{ route('specifications.uploadMwb', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
        </form>
        @if ($project->specification)
        <div class="mt-4">
            <h5><i class="fas fa-file-pdf"></i> Cahier de Charges actuel :</h5>

            <a href="{{ route('specifications.view', $project->specification->id) }}" class="btn btn-outline-primary ms-2">
                <i class="fas fa-eye"></i> Voir le cahier de charges
            </a>

            @if(!$project->archived)
            <form action="{{ route('specifications.destroy', $project->specification->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Supprimer ce fichier PDF ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-trash-alt"></i> Supprimer le cahier de charges
                </button>
            </form>
            @endif
        </div>
        @endif
    </div>
    @endif

    <!-- MWB File Display -->
    @if ($project->specification && $project->specification->mwb_file)
    <div class="mt-3">
        <h5><i class="fas fa-database"></i> Diagramme de classe actuel :</h5>
        <a href="{{ route('specifications.downloadMwb', $project->specification->id) }}" class="btn btn-outline-success">
            <i class="fas fa-download"></i> Télécharger le fichier .mwb
        </a>
        <a href="{{ route('specifications.viewMwb', $project->specification->id) }}" class="btn btn-outline-primary">
            <i class="fas fa-eye"></i> Voir le diagramme de classe
        </a>
        <form action="{{ route('specifications.deleteMwb', $project->specification->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Supprimer ce fichier MWB ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-trash-alt"></i> Supprimer le fichier .mwb
            </button>
        </form>
    </div>
    @endif

    <br>

    @if(!$project->archived)
    <a href="{{ route('modules.create', ['projectId' => $project->id]) }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Ajouter un Module
    </a>
    @else
    <div class="alert alert-info">
        Ce projet est archivé. Vous ne pouvez ni modifier, ni ajouter ou supprimer des éléments.
    </div>
    @endif

    <h3>Modules :</h3>

    @foreach ($project->modules as $module)
    <div class="module-task-wrapper">
        <div class="module-card">
            <h5>{{ $module->name }}</h5>
            <p>{{ Str::limit($module->description, 100) }}</p>

            @if(!$project->archived)
            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="{{ route('modules.tasks.create', [$project->id, $module->id]) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-tasks"></i> Ajouter une Tâche
                </a>
                <a href="{{ route('modules.edit', [$project->id, $module->id]) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="{{ route('modules.destroy', [$project->id, $module->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </form>
            </div>
            @endif
        </div>

        <div class="task-list">
            <h5 class="mb-3"><i class="fas fa-tasks"></i> Tâches :</h5>
            <ul class="list-group">
                @foreach ($module->tasks as $task)
                <li class="list-group-item mb-3 p-3 rounded shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $task->title }}</strong><br>
                            <small class="text-muted">{{ $task->description }}</small>
                        </div>

                        @if(!$project->archived)
                        <form action="{{ route('tasks.updateStatus', [$project->id, $module->id, $task->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <button type="submit" name="status" value="en_attente"
                                    class="btn btn-sm {{ $task->status == 'en_attente' ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <i class="fas fa-clock"></i>
                                </button>
                                <button type="submit" name="status" value="en_cours"
                                    class="btn btn-sm {{ $task->status == 'en_cours' ? 'btn-warning' : 'btn-outline-warning' }}">
                                    <i class="fas fa-spinner"></i>
                                </button>
                                <button type="submit" name="status" value="complété"
                                    class="btn btn-sm {{ $task->status == 'complété' ? 'btn-success' : 'btn-outline-success' }}">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </div>
                        </form>
                        @endif
                    </div>

                    @if(!$project->archived)
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('tasks.edit', [$project->id, $module->id, $task->id]) }}" class="btn btn-sm btn-warning me-2">
                            Modifier
                        </a>
                        <form action="{{ route('tasks.destroy', [$project->id, $module->id, $task->id]) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach

</div>
@endsection