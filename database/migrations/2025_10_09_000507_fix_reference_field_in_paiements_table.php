<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            // Rendre la colonne reference nullable avec une valeur par défaut
            $table->string('reference')->nullable()->default('PAY_' . date('YmdHis'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            // Revenir à l'état précédent (non nullable sans valeur par défaut)
            $table->string('reference')->nullable(false)->change();
        });
    }
};
