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
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('telephone', 30)->comment("L'indicatif suivit du numéro");
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('whatsapp', 30)->nullable()->comment("L'indicatif suivit du numéro");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
