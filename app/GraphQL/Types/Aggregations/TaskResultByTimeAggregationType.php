<?php


namespace App\GraphQL\Types\Aggregations;


use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\TaskResult;

class TaskResultByTimeAggregationType extends GraphQLType
{
    protected $attributes = [
        'name' => 'TaskResultByTimeAggregation',
        'model' => TaskResult::class
    ];

    public function fields(): array
    {
        return [
            'user' => [
                'type' => GraphQL::type('User')
            ],
            'task' => [
                'type' => GraphQL::type('Task')
            ],
            'skill' => [
                'type' => GraphQL::type('Skill')
            ],
            'total_assessment' => [
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }
}
