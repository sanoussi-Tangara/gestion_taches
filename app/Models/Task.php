<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'module_id',
        'project_id',
    ];

    // Relation avec le modèle Module
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
