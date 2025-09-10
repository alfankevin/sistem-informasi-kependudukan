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
        Schema::create('pengurus_wilayah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penduduk_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('jabatan');
            $table->string('wilayah_rw', 3)->nullable();
            $table->string('wilayah_rt', 3)->nullable();
            $table->text('ttd_path')->nullable();

            $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('pengurus_wilayah');
    }
};
