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
        Schema::create('detailserti', function (Blueprint $table) {
            $table->integer('id_detailserti')->autoIncrement();
            // $table->integer('id_sertifikasi');
            // $table->foreign('id_sertifikasi')->references('id_sertifikasi')->on('sertifikasi');
            // $table->string('nama_peserta',50);
            // $table->integer('status');

             // Replace 'nama_tabel_prodi' with the actual table name
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailserti');
    }
};
