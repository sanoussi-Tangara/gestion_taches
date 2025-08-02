@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4><i class="fas fa-info-circle"></i> Visualisation du Fichier MWB (Diagramme de Classe)</h4>
        </div>
        <div class="card-body">
            <p>Les fichiers <code>.mwb</code> (MySQL Workbench) contiennent des diagrammes de base de données et sont conçus pour être ouverts avec l'application <strong>MySQL Workbench</strong>.</p>
            <p>Ils ne peuvent pas être affichés directement dans votre navigateur web comme un document PDF ou une image.</p>
            
            <div class="alert alert-info">
                <strong>Pour visualiser le diagramme de classe :</strong>
                <ol class="mb-0">
                    <li>Téléchargez le fichier <code>.mwb</code> sur votre ordinateur en utilisant le bouton ci-dessous.</li>
                    <li>Ouvrez l'application MySQL Workbench.</li>
                    <li>Dans MySQL Workbench, ouvrez le fichier <code>.mwb</code> que vous venez de télécharger (généralement via "File" > "Open Model...").</li>
                </ol>
            </div>

            <p class="mt-4">Vous pouvez télécharger le fichier ici :</p>
            <a href="{{ route('specifications.downloadMwb', $specification->id) }}" class="btn btn-success">
                <i class="fas fa-download"></i> Télécharger le fichier .mwb ({{ basename($specification->mwb_file) }})
            </a>
            <br><br>
            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Retour</a>
        </div>
    </div>
</div>
@endsection