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
        Schema::create('rentang_kriterias', function (Blueprint $table) {
            /**
             * with primary() function, we can create composite primary key
             */
            $table->string('kode', 8);
            $table->foreign('kode')->references('kode')->on('kriterias')->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('rentang_min', 10, 3);
            $table->float('rentang_max', 10, 3);
            $table->primary(['kode', 'rentang_min', 'rentang_max']);

            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentang_kriterias');
    }
};
