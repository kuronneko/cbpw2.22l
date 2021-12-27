<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmbedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('embed_videos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('album_id')->unique(); // Relación con albums
            $table->foreign('album_id')->references('id')->on('albums'); // clave foranea
            $table->text('url');
            $table->text('preview');
            $table->text('host');
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
        Schema::dropIfExists('embed_videos');
    }
}
