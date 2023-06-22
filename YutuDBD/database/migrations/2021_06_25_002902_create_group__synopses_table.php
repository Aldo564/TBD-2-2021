<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupSynopsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group__synopses', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('id_group')->nullable();
            $table->foreign('id_group')->references('id')->on('groups');
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
        Schema::dropIfExists('group__synopses');
    }
}
