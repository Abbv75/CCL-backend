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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->text("nom");
            $table->bigInteger("prixAchat");
            $table->bigInteger("prixVenteDetails");
            $table->bigInteger("prixVenteEngros");
            $table->integer("quantite")->default(0);
            $table->timestamps();

            $table->foreignId("id_boutique")->constrained("boutiques")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("id_categorie")->nullable()->constrained("categories")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
