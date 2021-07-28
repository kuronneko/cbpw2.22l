<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id'); // Relación con usuarios
            $table->foreign('user_id')->references('id')->on('users'); // clave foranea

            $table->string('name');
            $table->text('description');
            $table->integer('visibility');
            //$table->integer('view');

            //$table->integer('size');
            //$table->integer('qcomments');
            //$table->integer('qlikes');
            //$table->integer('qimages');
            //$table->integer('qvideos');

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
        Schema::dropIfExists('albums');
    }
}
