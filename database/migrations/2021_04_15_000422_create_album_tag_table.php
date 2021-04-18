<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_tag', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('album_id'); // Relación con usuarios
            $table->foreign('album_id')->references('id')->on('albums'); // clave foranea

            $table->unsignedBigInteger('tag_id'); // Relación con usuarios
            $table->foreign('tag_id')->references('id')->on('tags'); // clave foranea

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
        Schema::dropIfExists('album_tag');
    }
}
