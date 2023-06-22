<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_methods', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('numero_tarjeta');
            $table->string('nombre_cliente', 40);
            $table->string('apellido_cliente', 40);
            $table->smallInteger('mes_expiracion');
            $table->smallInteger('anio_expiracion');

            $table->boolean('deleted');

            $table->unsignedSmallInteger('tipo_metodo')->nullable();
            $table->foreign('tipo_metodo')->references('id')->on('type_of_payments');
            $table->unsignedSmallInteger('id_banco')->nullable();
            $table->foreign('id_banco')->references('id')->on('banks');
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
        Schema::dropIfExists('pay_methods');
    }
}
