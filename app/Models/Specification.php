<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'pdf_path',  'mwb_file', 'filename'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
