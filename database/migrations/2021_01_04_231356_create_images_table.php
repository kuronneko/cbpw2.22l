<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('album_id'); // Relación con albums
            $table->foreign('album_id')->references('id')->on('albums'); // clave foranea

            $table->string('url');
            $table->string('ext');
            $table->integer('size');
            $table->string('basename');
            $table->ipAddress('ip');
            $table->string('tag');
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
        Schema::dropIfExists('images');
    }
}
