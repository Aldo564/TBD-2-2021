<?php

namespace Database\Factories;

use App\Models\Category_Synopsis;
use App\Models\Category;
use App\Models\Synopsis;
use Illuminate\Database\Eloquent\Factories\Factory;

class Category_SynopsisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category_Synopsis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_categoria' => Category::all()->random()->id,
            'id_sinopsis' => Synopsis::all()->random()->id,
            'deleted' => false,
        ];
    }
}
