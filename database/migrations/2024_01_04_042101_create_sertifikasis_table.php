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
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->integer('id_sertifikasi')->autoIncrement();
            $table->integer('id_prodi');
            $table->foreign('id_prodi')->references('id_prodi')->on('prodi');
            $table->string('nama_sertifikasi',50);
            $table->date('tanggal_sertifikasi');
            $table->string('lembaga',50);
            $table->string('level',50);
            $table->string('buktipendukung');
            $table->integer('kompeten');
            $table->integer('tidakkompeten');
            $table->integer('tidakhadir');
            $table->integer('jumlah');
            $table->string('status',50)->default('Aktif');
            // $table->date('tanggal_sertifikasi');

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
        Schema::dropIfExists('sertifikasi');
    }
};
