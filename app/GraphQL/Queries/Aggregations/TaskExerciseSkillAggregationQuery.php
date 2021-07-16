<?php

namespace App\GraphQL\Queries\Aggregations;

use Closure;
use App\Models\Task;
use Rebing\GraphQL\Support\Query;
use Illuminate\Database\Eloquent\Model;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Collection;
use GraphQL\Type\Definition\Type as GraphQLType;

class TaskExerciseSkillAggregationQuery extends Query
{
    /**
     * @return GraphQLType
     */
    public function type(): GraphQLType
    {
        return GraphQL::type('TaskExerciseSkillAggregation');
    }

    /**
     * @param $root
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @param Closure $getSelectFields
     * @return Builder|Builder[]|Collection|Model|null
     */
//    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields): Model|Collection|Builder|array|null
    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
//        $fields = $getSelectFields();

        var_dump('dsfsdfdsf');

//        return Task::query()
//            ->select($fields->getSelect())
//            ->with($fields->getRelations())
//            ->findOrFail($args['id']);
    }
}
