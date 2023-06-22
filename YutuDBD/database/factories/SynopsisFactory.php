<?php

namespace Database\Factories;

use App\Models\Synopsis;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class SynopsisFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Synopsis::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo_video' => $this->faker->word,
            'restriccion_edad' => $this->faker->numberBetween($min = 8, $max = 21),
            'descripcion' => $this->faker->text(),
            'link_imagen' => $this->faker->imageUrl($width = 480, $height = 640),
            'fecha_creacion' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'id_video' => Video::all()->random()->id,
            'deleted' => false,
        ];
    }
}
