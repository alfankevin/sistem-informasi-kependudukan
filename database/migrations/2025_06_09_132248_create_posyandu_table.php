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
            $table->float('tinggi_badan', 5, 2);
            $table->float('berat_badan', 5, 2);
            $table->float('lingkar_lengan_atas', 5, 2);
            $table->float('lingkar_lengan_bawah', 5, 2);
            $table->float('lingkar_dada', 5, 2);
            $table->float('lingkar_perut', 5, 2);
            $table->float('lingkar_kepala', 5, 2);
            $table->float('gizi', 5, 2);
            $table->string('status_vaksin')->nullable();
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
