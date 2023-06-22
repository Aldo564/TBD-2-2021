<?php

namespace Database\Factories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{

    protected $model = Permission::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->text($maxNbChars = 20),
            'descripcion'=> $this->faker->text($maxNbChars = 140),
            'deleted' => false,
        ];
    }
}
