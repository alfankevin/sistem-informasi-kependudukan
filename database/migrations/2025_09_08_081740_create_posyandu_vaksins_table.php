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
        Schema::create('posyandu_vaksins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('posyandu_id')->nullable();
            $table->unsignedBigInteger('vaksin_id')->nullable();
            $table->integer('dosis_ke')->nullable();
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
        Schema::dropIfExists('posyandu_vaksins');
    }
};
