<?php


namespace App\GraphQL\Queries\Skill;


use App\Models\Skill;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class SkillQuery extends Query
{
    protected $attributes = [
        'name' => 'skill'
    ];

    public function type(): Type
    {
        return GraphQL::type('Skill');
    }

    #[ArrayShape(['id' => "array"])]
    public function args(): array
    {
        return [
            'id' => [
                'name'  => 'id',
                'type'  => Type::int(),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        return Skill::query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->find($args['id']);
    }
}
