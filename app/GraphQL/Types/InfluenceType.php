<?php


namespace App\GraphQL\Types;

use App\Models\Influence;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class InfluenceType extends GraphQLType
{
    protected $attributes = [
        'name'  => 'Influence',
        'model' => Influence::class,
    ];

    public function fields(): array
    {
        return [
            'id'    => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Id of task'
            ],
            'value' => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'Influence of task on skill'
            ],
            'task'  => [
                'type' => GraphQL::type('Task')
            ],
            'skill' => [
                'type' => GraphQL::type('Skill')
            ]
        ];
    }

}
