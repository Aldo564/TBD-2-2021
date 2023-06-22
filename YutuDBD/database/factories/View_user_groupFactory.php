<?php

namespace Database\Factories;

use App\Models\View_user_group;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class View_user_groupFactory extends Factory
{

    protected $model = View_user_group::class;


    public function definition()
    {
        return [
            'id_lista' => Group::all()->random()->id,
            'id_usuario' => User::all()->random()->id,
            'deleted' => false,
        ];
    }
}
