<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_chapters_table.php
public function up()
{
    Schema::create('chapters', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('pdf')->nullable();      // chemin pdf dans public/chapitres/
        $table->string('video')->nullable();    // chemin video dans public/chapitres/
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
