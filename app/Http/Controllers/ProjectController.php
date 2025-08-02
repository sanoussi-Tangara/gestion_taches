<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Afficher tous les projets
    public function index()
    {
        $projects = Project::where('archived', false)->get();
        $archivedProjects = Project::where('archived', true)->get();

        return view('projects.index', compact('projects', 'archivedProjects'));
    }


    // Afficher le formulaire de création d'un projet
    public function create()
    {
        return view('projects.create');
    }

    // Sauvegarder un projet dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.index');
    }

    // Afficher un projet spécifique
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    // Afficher le formulaire de modification d'un projet
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Un projet archivé ne peut pas être modifié. Veuillez le réactiver d\'abord.');
        }
        return view('projects.edit', compact('project'));
    }

    // Mettre à jour un projet
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $project = Project::findOrFail($id);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Un projet archivé ne peut pas être modifié. Veuillez le réactiver d\'abord.');
        }

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.index');
    }
    public function archive(Project $project)
    {
        $project->archived = !$project->archived;
        $project->save();

        $message = $project->archived ? 'Projet archivé avec succès.' : 'Projet réactivé avec succès.';

        return redirect()->route('projects.index')->with('success', $message);
    }

    public function activate(Project $project)
    {
        $project->archived = false;
        $project->save();

        return redirect()->route('projects.show', $project->id)->with('success', 'Projet réactivé avec succès.');
    }



    // Supprimer un projet
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index');
    }
}
