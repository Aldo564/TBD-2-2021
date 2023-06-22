<?php

namespace Database\Factories;

use App\Models\User_PayMethod;
use App\Models\User;
use App\Models\PayMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class User_PayMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User_PayMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_usuario' => User::all()->random()->id,
            'id_metodoPago' => PayMethod::all()->random()->id,
            'deleted' => false,
        ];
    }
}
