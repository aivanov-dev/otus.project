<?php

namespace App\GraphQL\Queries\TaskResult;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
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
        if (empty($args['id'])) {
            $result = \DB::select(
                "SELECT calculate_assessments(exercise_groups.*), id, name
FROM exercise_groups where parent_id isnull;");
        } else {
            $result = \DB::select(
                "SELECT calculate_assessments(exercise_groups.*), id, name
FROM exercise_groups where parent_id = {$args['id']} AND calculate_assessments(exercise_groups.*) is not null;");
        }

        return $result;
    }
}
