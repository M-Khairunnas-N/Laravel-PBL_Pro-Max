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
        Schema::create('history_bantuan_pangans', function (Blueprint $table) {
            /**
             * with primary() function, we can create composite primary key
             */
            $table->foreignId('penduduk_id')->constrained('penduduks', 'penduduk_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('rentang_pemeriksaan', 50);
            $table->primary(['penduduk_id', 'rentang_pemeriksaan']);

            $table->string('peringkat', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_bantuan_pangans');
    }
};
