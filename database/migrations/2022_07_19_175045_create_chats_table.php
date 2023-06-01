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
            $table->text('mensaje');
            $table->integer('id_usuario');
            $table->string('name');
            $table->string('email');
            $table->date('fecha');
            $table->time('hora');
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
