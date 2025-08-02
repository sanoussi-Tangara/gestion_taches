<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Project;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function create($projectId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }
        return view('modules.create', compact('project'));
    }
    public function store(Request $request, $projectId)
    {
        // Trouver le projet avec l'ID
        $project = Project::findOrFail($projectId);

        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Créer un module lié à ce projet
        $project->modules()->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);


        // Rediriger vers la page du projet
        return redirect()->route('projects.show', ['project' => $projectId]);
    }


    public function edit($projectId, $moduleId)
    {
        $project = Project::findOrFail($projectId); // Récupérer le projet
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }
        $module = Module::findOrFail($moduleId);
        return view('modules.edit', compact('module', 'projectId'));
    }

    public function update(Request $request, $projectId, $moduleId)
    {
        $project = Project::findOrFail($projectId); // Récupérer le projet
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $module = Module::findOrFail($moduleId);
        $module->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->route('projects.show', $projectId)->with('success', 'Module modifié avec succès.');
    }

    public function destroy($projectId, $moduleId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }
        $module = $project->modules()->findOrFail($moduleId);
        $module->delete();

        return redirect()->route('projects.show', ['project' => $projectId]);
    }
}
