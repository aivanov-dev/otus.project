<?php

namespace Database\Factories;

use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class ExerciseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exercise::class;

    #[ArrayShape(['name' => "bool"])]
    public function definition(): array
    {
        return [
            'name' => 'Ex. #' . $this->faker->bothify('#?#-#?#')
        ];
    }
}
