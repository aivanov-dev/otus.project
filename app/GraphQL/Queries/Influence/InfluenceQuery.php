<?php


namespace App\GraphQL\Queries\Influence;


use App\Models\Influence;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class InfluenceQuery extends Query
{

    public function type(): GraphQLType
    {
        return GraphQL::type('Influence');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name'  => 'id',
                'type'  => GraphQLType::int(),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        return Influence::query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->findOrFail($args['id']);
    }
}
