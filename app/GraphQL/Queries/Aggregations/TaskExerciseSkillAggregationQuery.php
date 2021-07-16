<?php

namespace App\GraphQL\Queries\Aggregations;

use Closure;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use Rebing\GraphQL\Support\Query;
use Illuminate\Database\Eloquent\Model;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
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
     * @return array[]
     */
    #[ArrayShape(['task_id' => "array"])]
    public function args(): array
    {
        return [
            'task_id' => [
                'name'  => 'task_id',
                'type'  => GraphQLType::int(),
                'rules' => ['required']
            ]
        ];
    }

    /**
     * @param $root
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @param Closure $getSelectFields
     * @return Model
     */
    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields): Model
    {
        //МОЖЕТ ДЛЯ АГРЕГАЦИИ НУЖНО СДЕЛАТЬ ЧЕРЕЗ SCOPE В МОДЕЛИ?
        $fields = $getSelectFields();
        return Task::query()
//            ->select($fields->getSelect(), DB::raw('SUM(experiences.experience) as total_experience'))
//            ->select($fields->getSelect())
            ->with($fields->getRelations())
//            ->groupBy('tasks.title', 'exercises.name', 'skills.name')
            ->findOrFail($args['task_id'])
        ;
    }
}
