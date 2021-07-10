<?php


namespace App\GraphQL\Types;


use App\Models\Skill;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SkillType extends GraphQLType
{
    protected $attributes = [
        'name'  => 'Skill',
        'model' => Skill::class,
    ];

    public function fields(): array
    {
        return [
            'id'   => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'ID of skill'
            ],
            'code' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Code of skill'
            ],
            'name' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'Name of skill'
            ],
            'influences' => [
                'type' => Type::listOf(GraphQL::type('Influence'))
            ],
        ];
    }
}
