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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->char('no_kk',16);
            $table->char('nik', 16);
            $table->boolean('kepala_keluarga')->default(false);
            $table->string('nama', 128);
            $table->string('tempat_lahir', 128);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L','P']);
            $table->string('golongan_darah', 2);
            $table->string('agama', 16);
            $table->string('status_perkawinan', 32);
            $table->string('pekerjaan', 128);
            $table->string('alamat', 256);
            $table->integer('rt');
            // $table->foreignId('sosial_id');
            $table->unsignedBigInteger('sosial_id')->default(0);
            $table->foreign('sosial_id')->references('id')->on('sosial')->onDelete('cascade');
            $table->string('keterangan', 128);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penduduk');
    }
};
