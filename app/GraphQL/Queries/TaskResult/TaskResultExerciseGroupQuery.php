<?php

namespace App\GraphQL\Queries\TaskResult;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Facades\Cache;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class TaskResultExerciseGroupQuery extends Query
{
    public function type(): GraphQLType
    {
        return GraphQLType::listOf(GraphQL::type('TaskResult'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => GraphQLType::int()
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $query = 'SELECT calculate_assessments(exercise_groups.*), id, name
FROM exercise_groups where parent_id';

        if (empty($args['id'])) {
            $result = Cache::remember('TaskResultExerciseGroupAggregation', now()->addMinutes(250), function () use ($query) {
                return \DB::select("{$query} isnull;");
            });
        } else {
            $result = Cache::remember('TaskResultExerciseGroupAggregation_' . $args['id'], now()->addMinutes(250), function () use ($args, $query) {
                return \DB::select("{$query} = {$args['id']} AND calculate_assessments(exercise_groups.*) is not null;");
            });
        }
        return $result;
    }
}
