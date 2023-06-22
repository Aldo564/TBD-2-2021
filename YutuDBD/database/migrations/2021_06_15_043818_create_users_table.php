<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nickname', 200);
            $table->string('contrasenia', 400);
            $table->smallInteger('edad');
            $table->string('email')->unique();
            $table->integer('saldo');
            $table->timestamp('email_verified_at')->nullable();
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('id_comuna')->nullable();
            $table->foreign('id_comuna')->references('id')->on('communes');
            $table->timestamps();
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
        Schema::dropIfExists('users');
    }
}
