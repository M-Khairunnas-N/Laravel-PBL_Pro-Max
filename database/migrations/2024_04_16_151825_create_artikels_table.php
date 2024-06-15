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
        Schema::create('artikels', function (Blueprint $table) {
            $table->id('artikel_id');

            /**
             * create table for foreign() function in laravel or
             * foreign relationship for kader_id that can be null
             *
             * because when use foreignId() we cannot make those column null
             */
            $table->unsignedBigInteger('kader_id')->index()->nullable();
            $table->foreign('kader_id')->references('kader_id')->on('kaders')->nullOnDelete()->cascadeOnUpdate();

            $table->string('judul', 250) ;
            $table->text('isi') ;
            $table->string('tag', 100)->nullable();
            $table->string('foto_artikel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikels');
    }
};
