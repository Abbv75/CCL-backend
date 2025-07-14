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
            $table->id();
            $table->string('nomComplet', 50);
            $table->string('login', 50);
            $table->text('password');
            $table->timestamps();

            $table->foreignId("id_role")->constrained("roles")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("id_contact")->nullable()->constrained("contacts")->restrictOnDelete()->cascadeOnUpdate();
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
