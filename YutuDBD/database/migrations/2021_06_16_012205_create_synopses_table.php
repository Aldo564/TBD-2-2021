<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSynopsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synopses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titulo_video', 140);
            $table->smallInteger('restriccion_edad');
            $table->text('descripcion');
            $table->text('link_imagen');
            $table->date('fecha_creacion');
            $table->unsignedSmallInteger('id_video')->nullable();
            $table->foreign('id_video')->references('id')->on('videos');
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
        Schema::dropIfExists('synopses');
    }
}
