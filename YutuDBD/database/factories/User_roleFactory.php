<?php

namespace Database\Factories;

use App\Models\User_role;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class User_roleFactory extends Factory
{

    protected $model = User_role::class;


    public function definition()
    {
        return [
            'id_usuario' => User::all()->random()->id,
            'id_rol' => Role::all()->random()->id,
            'deleted' => false,
        ];
    }
}
