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
        Schema::table('specifications', function (Blueprint $table) {
            // Ajouter la colonne pdf_path
            $table->string('pdf_path');
        });
    }

    public function down()
    {
        Schema::table('specifications', function (Blueprint $table) {
            // Supprimer la colonne pdf_path
            $table->dropColumn('pdf_path');
        });
    }
};
