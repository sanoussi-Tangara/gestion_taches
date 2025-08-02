<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Le titre de la tâche
            $table->text('description')->nullable(); // Description de la tâche
            $table->enum('status', ['en_cours', 'complété', 'en_attente'])->default('en_attente'); // Statut de la tâche
            $table->foreignId('module_id')->constrained()->onDelete('cascade'); // Référence au module, suppression en cascade
            $table->timestamps(); // Date de création et mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
