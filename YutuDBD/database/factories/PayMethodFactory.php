<?php

namespace Database\Factories;

use App\Models\PayMethod;
use App\Models\TypeOfPayment;
use App\Models\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero_tarjeta' => $this->faker->randomNumber($nbDigits = 4, $strict = true),
            'nombre_cliente' => $this->faker->name,
            'apellido_cliente' => $this->faker->lastName,
            'mes_expiracion' => $this->faker->month($max = 'now'),
            'anio_expiracion' => $this->faker->numberBetween($min = 2021, $max = 2031),
            'tipo_metodo' => TypeOfPayment::all()->random()->id,
            'id_banco' => Bank::all()->random()->id,
            'deleted' => false,
        ];
    }
}
