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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(column: 'id_penduduk')->nullable();
            $table->string('tracking_token')->unique();
            $table->char('nik_pemohon', 16);
            $table->string('nama_pemohon');
            $table->string('alamat_pemohon');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->text('keperluan');
            $table->string('jenis_surat');
            $table->text('pdf_path');
            $table->string('status');

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
        Schema::dropIfExists('pengajuan_surat');
    }
};
