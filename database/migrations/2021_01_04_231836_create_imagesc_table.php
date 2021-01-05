<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagescTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagesc', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('comment_id'); // Relación con categorias
            $table->foreign('comment_id')->references('id')->on('comments'); // clave foranea

            $table->string('url');
            $table->string('ext_image');
            $table->string('size');
            $table->string('basename');
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
        Schema::dropIfExists('imagesc');
    }
}
