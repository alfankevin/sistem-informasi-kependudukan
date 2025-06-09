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
        Schema::create('posyandu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penduduk');
            $table->integer('usia');
            $table->float('tinggi_badan');
            $table->float('berat_badan');
            $table->float('lingkar_lengan_atas');
            $table->float('lingkar_lengan_bawah');
            $table->float('lingkar_dada');
            $table->float('lingkar_perut');
            $table->float('lingkar_kepala');
            $table->float('gizi');

            $table->foreign('id_penduduk')->references('id')->on('penduduk')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('posyandu');
    }
};
