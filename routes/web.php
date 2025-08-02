<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SpecificationController;


// Route pour les projets
Route::resource('projects', ProjectController::class);

// Route pour les modules d'un projet
Route::prefix('projects/{projectId}')->group(function () {
    Route::resource('modules', ModuleController::class);
    Route::resource('modules.tasks', TaskController::class);
});

// Autres routes spécifiques pour modules (si nécessaire)
Route::get('projects/{projectId}/modules/create', [ModuleController::class, 'create'])->name('modules.create');
Route::post('projects/{projectId}/modules', [ModuleController::class, 'store'])->name('modules.store');
Route::delete('projects/{projectId}/modules/{moduleId}', [ModuleController::class, 'destroy'])->name('modules.destroy');

Route::patch('/projects/{project}/modules/{module}/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');


// Pour afficher le formulaire d'édition
Route::get('/projects/{projectId}/modules/{moduleId}/tasks/{taskId}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

// Pour mettre à jour la tâche
Route::put('/projects/{projectId}/modules/{moduleId}/tasks/{taskId}', [TaskController::class, 'update'])->name('tasks.update');

// Pour supprimer la tâche
Route::delete('/projects/{projectId}/modules/{moduleId}/tasks/{taskId}', [TaskController::class, 'destroy'])->name('tasks.destroy');
// Route d'accueil

Route::get('/', [ProjectController::class, 'index'])->name('home');

// Affiche le formulaire d'édition
Route::get('/projects/{project}/modules/{module}/edit', [ModuleController::class, 'edit'])->name('modules.edit');

// Met à jour le module
Route::put('/projects/{project}/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');




Route::post('/projects/{project}/specifications', [SpecificationController::class, 'store'])->name('specifications.store');
Route::get('/specifications/{specification}/download', [SpecificationController::class, 'download'])->name('specifications.download');

Route::get('/specifications/{specification}/view', [SpecificationController::class, 'view'])->name('specifications.view');

Route::delete('/specifications/{specification}', [SpecificationController::class, 'destroy'])->name('specifications.destroy');
Route::patch('/projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');
Route::post('/projects/{project}/activate', [ProjectController::class, 'activate'])->name('projects.activate');


Route::post('/specifications/{project}/upload-mwb', [SpecificationController::class, 'uploadMwb'])->name('specifications.uploadMwb');
Route::get('/specifications/mwb/{specification}/download', [SpecificationController::class, 'downloadMwb'])->name('specifications.downloadMwb');
Route::delete('/specifications/mwb/{specification}/delete', [SpecificationController::class, 'deleteMwb'])->name('specifications.deleteMwb');
Route::get('/specifications/mwb/{specification}/view', [SpecificationController::class, 'viewMwb'])->name('specifications.viewMwb');
