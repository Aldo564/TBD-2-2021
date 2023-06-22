<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $fecha = $this->faker->date($format = 'Y-m-d', $max = 'now');
        $edad = Carbon::parse($fecha)->diff(Carbon::now())->y;

        return [
            'nickname' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail(),
            'edad' => $edad,
            'email_verified_at' => now(),
            'saldo' => $this->faker->numberBetween($min = 1000, $max = 500000),
            'contrasenia' => bcrypt('secret'), // password
            'fecha_nacimiento' => $fecha,
            'id_comuna' => Commune::all()->random()->id,
            'deleted' => false,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
