<?php

namespace Database\Factories;

use App\Models\Role_permission;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class Role_permissionFactory extends Factory
{

    protected $model = Role_permission::class;

    public function definition()
    {
        return [
            'id_rol' => Role::all()->random()->id,
            'id_permiso' => Permission::all()->random()->id, 
            'deleted' => false,
        ];
    }
}
