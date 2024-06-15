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
        Schema::create('pemeriksaan_lansias', function (Blueprint $table) {
            $table->foreignId('pemeriksaan_id')->primary()->constrained('pemeriksaans', 'pemeriksaan_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('lingkar_perut', 6, 3);
            $table->integer('gula_darah');
            $table->integer('kolesterol');
            $table->integer('tensi_darah');
            $table->float('asam_urat', 5, 3);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_lansias');
    }
};
