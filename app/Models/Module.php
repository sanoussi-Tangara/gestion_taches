<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'project_id',
    ];

    // Relation avec le modèle Project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Relation avec le modèle Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
