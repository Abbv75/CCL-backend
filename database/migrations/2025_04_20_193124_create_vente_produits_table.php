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
        Schema::create('vente_produits', function (Blueprint $table) {
            $table->id();
            $table->integer('montant');
            $table->integer('quantite')->default(1);
            $table->timestamps();

            $table->foreignId('id_produit')->constrained('produits')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_vente')->constrained('ventes')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vente_produits');
    }
};
