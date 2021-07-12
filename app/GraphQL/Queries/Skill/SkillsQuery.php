<?php


namespace App\GraphQL\Queries\Skill;

use App\Models\Skill;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class SkillsQuery extends Query
{

    public function type(): GraphQLType
    {
        return GraphQLType::listOf(GraphQL::type('Skill'));
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        return Skill::query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->get();
    }
}
