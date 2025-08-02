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
    Schema::table('tasks', function (Blueprint $table) {
        $table->unsignedBigInteger('module_id')->nullable()->after('id');
        $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropForeign(['module_id']);
        $table->dropColumn('module_id');
    });
}

};
