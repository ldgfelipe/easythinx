<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            ///// datos de emisor
            $table->string('mensaje');
            $table->integer('id_usuario');
            $table->string('name');
            $table->string('email');
            ///// datos de remitente
            $table->integer('id_proyecto');
            $table->string('para'); /// id usuario o todos
            $table->string('tipo'); /// urgente, normal
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
