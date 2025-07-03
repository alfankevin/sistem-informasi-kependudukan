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
        Schema::create('stuntings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posyandu_id')->constrained('posyandu')->onDelete('cascade');
            $table->decimal('status_gizi', 8, 4);
            $table->decimal('nilai', 8, 4);
            $table->string('kategori');
            $table->timestamps();

            $table->index(['posyandu_id', 'nilai', 'kategori'], 'idx_posyandu_id_nilai_kategori');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stuntings');
    }
};
