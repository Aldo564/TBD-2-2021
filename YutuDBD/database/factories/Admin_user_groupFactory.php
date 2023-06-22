<?php

namespace Database\Factories;

use App\Models\Admin_user_group;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class Admin_user_groupFactory extends Factory
{

    protected $model = Admin_user_group::class;


    public function definition()
    {
        return [
            'id_lista' => Group::all()->random()->id,
            'id_usuario' => User::all()->random()->id,
            'es_colab'=>$this->faker-> boolean,
            'es_propietario' =>$this->faker->boolean,
            'deleted' => false,
        ];
    }
}
