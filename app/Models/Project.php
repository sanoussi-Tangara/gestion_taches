<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'archived'
    ];
    protected $casts = [
        'archived' => 'boolean',
    ];

    // Relation avec le modèle Module
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function specification()
    {
        return $this->hasOne(Specification::class);
    }
}
