<?php

namespace Database\Factories;

use App\Models\Group_Synopsis;
use App\Models\Group;
use App\Models\Synopsis;
use Illuminate\Database\Eloquent\Factories\Factory;

class Group_SynopsisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group_Synopsis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_group' => Group::all()->random()->id,
            'id_sinopsis' => Synopsis::all()->random()->id,
            'deleted' => false,
        ];
    }
}
