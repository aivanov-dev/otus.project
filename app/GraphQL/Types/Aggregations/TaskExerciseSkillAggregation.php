<?php

namespace App\GraphQL\Types\Aggregations;

use GraphQL\Type\Definition\Type;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskExerciseSkillAggregation extends GraphQLType
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'TaskExerciseSkillAggregation',
    ];

    /**
     * @return array[]
     */
    #[ArrayShape(['task' => "array", 'exercise' => "array", 'skill' => "array", 'total_experience' => "array"])]
    public function fields(): array
    {
        return [
            'task' => [
                'type' => GraphQL::type('Task')
            ],
            'exercise' => [
                'type' => GraphQL::type('Exercise')
            ],
            'skill' => [
                'type' => GraphQL::type('Skill')
            ],
            'total_experience' => [
                'type' => Type::float(),
                'description' => 'Sum of the experiences grouped by task title, exercise name and skill name'
            ]
        ];
    }
}
