<?php

namespace Database\Factories;

use App\Models\ExerciseGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExerciseGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExerciseGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word()
        ];
    }
}
