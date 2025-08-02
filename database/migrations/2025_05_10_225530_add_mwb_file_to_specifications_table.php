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
            $table->string('mwb_file')->nullable();
        });
    }

    public function down()
    {
        Schema::table('specifications', function (Blueprint $table) {
            $table->dropColumn('mwb_file');
        });
    }
};
