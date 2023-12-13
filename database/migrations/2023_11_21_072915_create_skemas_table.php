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
        Schema::create('skema', function (Blueprint $table) {
            $table->integer('id_skema')->primary();
            $table->string('nama_skema',50);
            $table->date('start_date');
            $table->date('end_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skema');
    }
};
