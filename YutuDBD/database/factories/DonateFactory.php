<?php

namespace Database\Factories;

use App\Models\Donate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user1 = User::all()->random()->id;
        $user2 = User::all()->random()->id;

        if($user1 == $user2){
            $user2 = User::all()->random()->id;
        }

        return [
            'id_usuario_Origen' => $user1,
            'id_usuario_Destino' => $user2,
            'monto' => $this->faker->numberBetween($min = 1000, $max = 500000),
            'fecha' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'deleted' => false,
        ];
    }
}
