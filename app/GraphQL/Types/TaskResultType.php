<?php

namespace App\GraphQL\Types;

use App\Models\TaskResult;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskResultType extends GraphQLType
{
    protected $attributes = [
        'name' => 'TaskResult',
        'model' => TaskResult::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of task result',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of course'
            ],
            'calculate_assessments' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'assessment of task',
            ],
        ];
    }
}
