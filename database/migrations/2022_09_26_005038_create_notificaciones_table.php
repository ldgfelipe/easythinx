<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre_des');
            $table->string('email_des');
            $table->longText('mensaje_des');
            $table->integer('id_user_des');
            $table->string('socket_des');
            $table->integer('id_user_rem');
            $table->string('nombre_rem');
            $table->string('socket_rem');
            $table->integer('status'); //// 0 no leido // 1 leido
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}
