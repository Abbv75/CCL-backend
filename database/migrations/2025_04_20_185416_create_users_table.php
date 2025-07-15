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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary;
            $table->string('nomComplet', 50);
            $table->string('login', 50);
            $table->string('motDePasse', 50);
            $table->string('idCOD')->nullable()->comment("Obligatoire si c'est un joureur");
            $table->timestamps();
            
            $table->string('id_role', 5);
            $table->foreign('id_role')->references('id')->on('roles')->cascadeOnDelete()->cascadeOnUpdate();
            
            $table->foreignUuid("id_contact")->constrained("contacts")->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
