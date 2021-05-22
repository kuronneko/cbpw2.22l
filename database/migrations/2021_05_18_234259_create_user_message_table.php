<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_message', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sender'); // Relación con usuarios
            $table->foreign('sender')->references('id')->on('users'); // clave foranea

            $table->unsignedBigInteger('receiver'); // Relación con usuarios
            $table->foreign('receiver')->references('id')->on('users'); // clave foranea

            $table->unsignedBigInteger('message_id'); // Relación con usuarios
            $table->foreign('message_id')->references('id')->on('tags'); // clave foranea

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
        Schema::dropIfExists('user_message');
    }
}
