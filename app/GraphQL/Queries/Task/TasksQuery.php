<?php


namespace App\GraphQL\Queries\Task;


use App\Models\Task;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class TasksQuery extends Query
{
    public function type(): GraphQLType
    {
        return GraphQLType::listOf(GraphQL::type('Task'));
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $fields = $getSelectFields();
        return Task::query()
            ->select($fields->getSelect())
            ->with($fields->getRelations())
            ->get();
    }
}
