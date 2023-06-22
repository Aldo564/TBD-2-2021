<?php

namespace Database\Factories;

use App\Models\Admin_User_Synopsis;
use App\Models\User;
use App\Models\Synopsis;
use Illuminate\Database\Eloquent\Factories\Factory;

class Admin_User_SynopsisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin_User_Synopsis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */




    public function definition()
    {
        return [
            'id_usuario' => User::all()->random()->id,
            'id_sinopsis' => Synopsis::all()->random()->id,
            'es_colab' => $this->faker->boolean,
            'es_propietario' => $this->faker->boolean,
            'deleted' => false,
        ];
    }
}
