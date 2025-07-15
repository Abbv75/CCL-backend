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
        Schema::create('partie_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();

            $table->foreignUuid('id_partie')->constrained('parties')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('id_user')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unique(['id_partie', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partie_users');
    }
};
