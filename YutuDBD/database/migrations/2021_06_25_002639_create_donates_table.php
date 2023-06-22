<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonatesTable extends Migration
{
    protected $primaryKey = 'id_donacion';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('monto');
            $table->date('fecha');
            $table->unsignedInteger('id_usuario_Origen')->nullable()->unsigned();
            $table->foreign('id_usuario_Origen')->references('id')->on('users');
            $table->unsignedInteger('id_usuario_Destino')->nullable()->unsigned();
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
        Schema::dropIfExists('donates');
    }
}
