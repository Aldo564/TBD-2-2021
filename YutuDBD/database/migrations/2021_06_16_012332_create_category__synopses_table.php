<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorySynopsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category__synopses', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('id_categoria')->nullable();
            $table->foreign('id_categoria')->references('id')->on('categories');
            $table->unsignedSmallInteger('id_sinopsis')->nullable();
            $table->foreign('id_sinopsis')->references('id')->on('synopses');
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
        Schema::dropIfExists('category__synopses');
    }
}
