<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descripcion' => $this -> faker -> text(),
            'nombre' => $this -> faker -> unique-> randomElement($array = array('Horror','Comedia','Acción','Romance','XXX','Suspenso','Anime','Sci-fi','Documental','Musical')),
            'deleted' => false,
        ];
    }
}
