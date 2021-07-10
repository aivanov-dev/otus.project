<?php


namespace App\GraphQL\Queries\Task;


use App\Models\Task;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class TaskQuery extends Query
{

    public function type(): GraphQLType
    {
        return GraphQL::type('Task');
    }

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
        return Task::query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->findOrFail($args['id']);
    }
}
