<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_paiements_table.php
public function up()
{
    Schema::create('paiements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->unsignedBigInteger('chapter_id');
        $table->string('methode'); // 'T-Money' ou 'Flooz'
        $table->string('numero');  // numéro payé (sans +228)
        $table->decimal('montant', 10, 2)->default(10000);
        $table->enum('statut', ['en_attente','approuve','rejete'])->default('en_attente');
        $table->timestamps();
        $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
