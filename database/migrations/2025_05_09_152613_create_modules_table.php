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
    Schema::create('modules', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Le nom du module
        $table->text('description')->nullable(); // Description du module
        $table->foreignId('project_id')->constrained(); // Référence au projet
        $table->timestamps(); // Date de création et mise à jour
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
