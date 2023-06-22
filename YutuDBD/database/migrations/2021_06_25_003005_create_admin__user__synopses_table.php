<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserSynopsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin__user__synopses', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->unsignedSmallInteger('id_sinopsis')->nullable();
            $table->foreign('id_sinopsis')->references('id')->on('synopses');
            $table->boolean('es_colab');
            $table->boolean('es_propietario');
            $table->boolean('deleted');
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
        Schema::dropIfExists('admin__user__synopses');
    }
}
