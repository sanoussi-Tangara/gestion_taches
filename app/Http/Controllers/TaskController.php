<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Module;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create($projectId, $moduleId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }
        $module = Module::findOrFail($moduleId);

        return view('tasks.create', compact('project', 'module'));
    }


    public function store(Request $request, $projectId, $moduleId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:en_cours,complété,en_attente',
        ]);

        $module = Module::findOrFail($moduleId);

        $module->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'project_id' => $projectId,
        ]);

        return redirect()->route('projects.show', $projectId);
    }

    public function updateStatus(Request $request, $projectId, $moduleId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        $request->validate([
            'status' => 'required|in:en_cours,complété,en_attente',
        ]);

        $task = Task::findOrFail($taskId);
        $task->status = $request->status;
        $task->save();

        return redirect()->route('projects.show', $projectId)->with('success', 'Statut mis à jour.');
    }


    public function edit($projectId, $moduleId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }
        $task = Task::findOrFail($taskId);
        return view('tasks.edit', compact('task', 'projectId', 'moduleId'));
    }

    public function update(Request $request, $projectId, $moduleId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|in:en_attente,en_cours,complété'
        ]);

        $task = Task::findOrFail($taskId);
        $task->update($request->all());

        return redirect()->route('projects.show', $projectId)->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy($projectId, $moduleId, $taskId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->archived) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Ce projet est archivé. Veuillez le réactiver pour effectuer cette action.');
        }

        $task = Task::findOrFail($taskId);
        $task->delete();

        return redirect()->route('projects.show', $projectId)->with('success', 'Tâche supprimée avec succès.');
    }
}
