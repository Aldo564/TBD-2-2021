<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('id_usuario_Origen')->nullable();
            $table->foreign('id_usuario_Origen')->references('id')->on('users');
            $table->unsignedInteger('id_usuario_Destino')->nullable();
            $table->foreign('id_usuario_Destino')->references('id')->on('users');
            $table->boolean('deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follows');
    }
}
