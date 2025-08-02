<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecificationController extends Controller
{
    public function store(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:20480', // 20 MB max
        ]);

        // Supprimer l'ancien PDF s'il existe
        if ($project->specification) {
            Storage::delete($project->specification->pdf_path);
            $project->specification->delete();
        }

        $uploadedFile = $request->file('pdf_file');
        $originalFilename = $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->store('specifications', 'public'); // Stocke dans storage/app/public/specifications

        $spec = new Specification([
            'pdf_path' => $path, // e.g., 'specifications/generated_name.pdf' (relatif au disque 'public')
            'filename' => $originalFilename, // Nom original du fichier
        ]);

        $project->specification()->save($spec);

        return redirect()->back()->with('success', 'Cahier de charges importé avec succès.');
    }

    // public function download($id)
    // {
    //     $spec = Specification::findOrFail($id);
    //     $filePathOnDisk = $spec->pdf_path; // Chemin tel que stocké, ex: 'specifications/xyz.pdf'

    //     // Vérifie si le fichier existe sur le disque 'public'
    //     if (!Storage::disk('public')->exists($filePathOnDisk)) {
    //         abort(404, 'Le fichier de spécification demandé n\'a pas pu être trouvé sur le serveur.');
    //     }

    //     return Storage::disk('public')->download($filePathOnDisk, $spec->filename);
    // }

    /**
     * Affiche le PDF de la spécification dans le navigateur.
     * Utilise le Route Model Binding pour injecter l'instance de Specification.
     */
    public function view(Specification $specification) // Changement ici: $id devient Specification $specification
    {
        // $spec = Specification::findOrFail($id); // N'est plus nécessaire grâce au Route Model Binding

        // Vérifie si le fichier existe sur le disque 'public'
        if (!Storage::disk('public')->exists($specification->pdf_path)) {
            abort(404, 'Fichier PDF introuvable sur le disque. Veuillez vérifier que le fichier a bien été téléversé.');
        }

        // Retourne directement le contenu du fichier PDF pour un affichage "inline" dans le navigateur.
        // Avec cette approche, la vue 'resources/views/specifications/view.blade.php' et sa mise en page
        // (y compris le bouton "Retour" personnalisé) ne seront plus utilisées pour afficher le PDF.
        return Storage::disk('public')->response($specification->pdf_path);
    }




    public function destroy($id)
    {
        $spec = Specification::findOrFail($id);
        $project = $spec->project; // Récupérer le projet associé à la spécification

        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        // Supprimer le fichier physique
        if (Storage::exists($spec->pdf_path)) {
            Storage::delete($spec->pdf_path);
        }

        // Supprimer la ligne en base
        $spec->delete();

        return redirect()->back()->with('success', 'Cahier de charges supprimé avec succès.');
    }



    public function uploadMwb(Request $request, $projectId)
    {
        $request->validate([
            'mwb_file' => 'required|mimes:mwb|max:10240'
        ]);

        $filePath = $request->file('mwb_file')->store('mwb_files');

        $project = Project::findOrFail($projectId);
        $spec = $project->specification;

        if (!$spec) {
            $spec = new Specification();
            $spec->project_id = $projectId;
        }

        $spec->mwb_file = $filePath;
        $spec->save();

        return back()->with('success', 'Diagramme de classe importé avec succès.');
    }

    public function downloadMwb(Specification $specification)
    {
        return Storage::download($specification->mwb_file);
    }

    public function deleteMwb(Specification $specification)
    {
        if (Storage::exists($specification->mwb_file)) {
            Storage::delete($specification->mwb_file);
        }

        $specification->update(['mwb_file' => null]);

        return back()->with('success', 'Fichier .mwb supprimé avec succès.');
    }

    public function viewMwb(Specification $specification)
    {
        // Assurez-vous que le fichier mwb existe pour cette spécification
        if (!$specification->mwb_file || !Storage::exists($specification->mwb_file)) {
            abort(404, 'Fichier MWB introuvable ou non spécifié.');
        }

        return view('specifications.mwb_info', compact('specification'));
    }
}
