<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Synopsis;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'texto' => $this->faker->text($maxNbChars = 140) ,
            'fecha' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'id_usuario' => User::all()->random()->id,
            'id_sinopsis' => Synopsis::all()->random()->id,
            'deleted' => false,
        ];
    }
}
