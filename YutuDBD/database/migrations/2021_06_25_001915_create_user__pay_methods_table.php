<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPayMethodsTable extends Migration
{
    protected $primaryKeu = 'id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__pay_methods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->unsignedSmallInteger('id_metodoPago')->nullable();
            $table->foreign('id_metodoPago')->references('id')->on('pay_methods');
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
        Schema::dropIfExists('user__pay_methods');
    }
}
