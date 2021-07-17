<?php

namespace App\GraphQL\Types;

use App\Models\Exercise;
use GraphQL\Type\Definition\Type;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ExerciseType extends GraphQLType
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'Exercise',
        'model' => Exercise::class
    ];

    /**
     * @return array[]
     */
    #[ArrayShape(['id' => "array", 'name' => "array"])]
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the exercise'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Name of the exercise'
            ]
        ];
    }
}
