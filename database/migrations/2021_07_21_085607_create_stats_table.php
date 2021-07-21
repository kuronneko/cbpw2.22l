<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('album_id')->unique(); // Relación con albums
            $table->foreign('album_id')->references('id')->on('albums'); // clave foranea

            $table->integer('view');
            $table->integer('size');
            $table->integer('qcomment');
            $table->integer('qlike');
            $table->integer('qimage');
            $table->integer('qvideo');
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
        Schema::dropIfExists('stats');
    }
}
