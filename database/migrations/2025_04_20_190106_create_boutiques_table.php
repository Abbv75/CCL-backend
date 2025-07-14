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
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->string("nom", 50);
            $table->text("image")->nullable();
            $table->dateTime("debutAbonnement")->nullable();
            $table->dateTime("finAbonnement")->nullable();
            $table->boolean("isPartenaire")->default(false);
            $table->float("pourcentageProduit")->nullable();
            $table->timestamps();

            $table->foreignId("id_contact")->constrained("contacts")->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId("id_type_abonnement")->nullable()->constrained("type_abonnements")->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boutiques');
    }
};
