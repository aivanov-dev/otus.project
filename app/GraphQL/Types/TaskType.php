<?php


namespace App\GraphQL\Types;


use App\Models\Task;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TaskType extends GraphQLType
{
    protected $attributes = [
        'name'  => 'Task',
        'model' => Task::class
    ];


    public function fields(): array
    {
        return [
            'id'          => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Id of task'
            ],
            'title'       => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Title of task'
            ],
            'description' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Description of task'
            ],
            'influences'  => [
                'type' => Type::listOf(GraphQL::type('Influence'))
            ]
        ];
    }
}
