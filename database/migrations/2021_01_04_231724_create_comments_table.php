<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('album_id'); // Relación con albums
            $table->foreign('album_id')->references('id')->on('albums'); // clave foranea

            $table->unsignedBigInteger('user_id'); // Relación con usuarios
            $table->foreign('user_id')->references('id')->on('users'); // clave foranea

            $table->string('name');
            $table->string('text');
            $table->string('ip');
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
        Schema::dropIfExists('comments');
    }
}
