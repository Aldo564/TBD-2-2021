<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->text($maxNbChars = 20),
            'descripcion'=> $this->faker->text($maxNbChars = 140),
            'deleted' => false,
        ];
    }
}
