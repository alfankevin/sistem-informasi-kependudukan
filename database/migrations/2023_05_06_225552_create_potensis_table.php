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
        Schema::create('potensi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_umkm', 128);
            $table->string('alamat_umkm', 128);
            $table->string('deskripsi_umkm', 512);
            $table->string('sosial_media', 128);
            $table->string('gambar_umkm');
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
        Schema::dropIfExists('potensi');
    }
};
