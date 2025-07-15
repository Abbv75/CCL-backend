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
        Schema::create('parties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('dateHeure');
            $table->foreignUuid('id_tournoi')->constrained('tournois')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_gagnant')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_status')->constrained('statuses')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
