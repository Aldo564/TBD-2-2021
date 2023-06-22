<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeUserSynopsesTable extends Migration
{
    protected $primaryKey = 'id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like__user__synopses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('estado');

            $table->boolean('deleted');

            $table->unsignedInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users');

            $table->unsignedInteger('id_sinopsis')->nullable();
            $table->foreign('id_sinopsis')->references('id')->on('synopses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like__user__synopses');
    }
}
