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
        Schema::create('tournois', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->date('date_debut')->nullable();
            $table->decimal('frais_inscription', 8, 2)->nullable()->default(0);
            $table->decimal('montant_a_gagner', 8, 2)->nullable();
            $table->integer('nb_max_participants')->nullable();
            $table->timestamps();

            $table->string('id_status',5);
            $table->foreign('id_status')->references('id')->on('statuses')->cascadeOnDelete()->cascadeOnUpdate();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournois');
    }
};
