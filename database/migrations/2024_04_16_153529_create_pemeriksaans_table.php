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
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id('pemeriksaan_id');
            $table->foreignId('kader_id')->constrained('kaders', 'kader_id')->cascadeOnUpdate();
            $table->foreignId('penduduk_id')->constrained('penduduks', 'penduduk_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('tgl_pemeriksaan')->default(now('Asia/Jakarta')->locale('id'));
            $table->enum('golongan', ['bayi', 'lansia']);
            $table->float('berat_badan', 6, 3);
            $table->float('tinggi_badan', 6, 3);
            $table->enum('status', ['sakit', 'sehat'])->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
