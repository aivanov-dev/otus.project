<?php

namespace Database\Factories;

use App\Models\Exercise;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exercise::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string"])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
