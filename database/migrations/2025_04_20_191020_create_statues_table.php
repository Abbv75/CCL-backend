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
        Schema::create('statues', function (Blueprint $table) {
            $table->id();
            $table->text('media');
            $table->text('typeMedia');
            $table->integer('delais')->default(24);
            $table->timestamps();

            $table->foreignId("id_boutique")->constrained("boutiques")->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statues');
    }
};
