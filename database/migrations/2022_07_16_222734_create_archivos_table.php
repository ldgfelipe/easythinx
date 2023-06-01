<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('urlArchivo');
            $table->string('nombre');
            $table->integer('user');
            $table->integer('permiso'); // 1 visible - no descarga, 2 visble - descarga, 3 no visible collaboradores
            $table->integer('id_proyecto');
            $table->string('extension');
            $table->longtext('asignado');
            $table->integer('folder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivos');
    }
}
