<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebbuildersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webbuilders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombrepage');
            $table->string('metatags');
            $table->longText('html');
            $table->string('url');
            $table->integer('visitas');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webbuilders');
    }
}
