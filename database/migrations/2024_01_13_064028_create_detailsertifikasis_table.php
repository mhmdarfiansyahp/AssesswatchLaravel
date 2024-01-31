<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailsertifikasi', function (Blueprint $table) {
            // $table->integer('id_detail_sertifikasi')->autoIncrement();
            $table->integer('id_sertifikasi');
            $table->foreign('id_sertifikasi')->references('id_sertifikasi')->on('sertifikasi');
            $table->date('tanggal_sertifikasi');
            $table->string('lembaga',50);
            $table->string('level',50);
            $table->integer('levelKKNI');
            $table->string('buktipendukung');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailsertifikasi');
    }
};
