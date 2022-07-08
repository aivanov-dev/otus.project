<?php

namespace App\GraphQL\Queries\Aggregations;

use App\Models\Task;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class TaskExerciseSkillAggregationsQuery extends Query
{
    /**
     * @return GraphQLType
     */
    public function type(): GraphQLType
    {
        return GraphQLType::listOf(GraphQL::type('TaskExerciseSkillAggregation'));
    }

    /**
     * @param $root
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @param Closure $getSelectFields
     *
     * @return Collection
     */
    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields): Collection
    {
        return Cache::remember('TaskExerciseSkillAggregation', now()->addMinutes(250), function () {
            return Task::query()
                ->select(
                    'tasks.id as task_id',
                    'tasks.title as task_title',
                    'tasks.description as task_description',
                    'exercises.id as exercise_id',
                    'exercises.name as exercise_name',
                    'skills.id as skill_id',
                    'skills.code as skill_code',
                    'skills.name as skill_name',
                    DB::raw('SUM(experiences.experience) as total_experience')
                )
                ->leftJoin('exercises', 'exercises.id', '=', 'tasks.exercise_id')
                ->leftJoin('task_results', 'task_results.task_id', '=', 'tasks.id')
                ->leftJoin('experiences', 'experiences.user_id', '=', 'task_results.user_id')
                ->leftJoin('skills', 'skills.id', '=', 'experiences.skill_id')
                ->groupBy('tasks.id', 'exercises.id', 'skills.id')
                ->get()
                ->map(function ($value) {
                    if ($value->task_id && $value->exercise_id && $value->skill_id) {
                        return [
                            'task' => [
                                'id' => $value->task_id,
                                'title' => $value->task_title,
                                'description' => $value->task_description
                            ],
                            'exercise' => [
                                'id' => $value->exercise_id,
                                'name' => $value->exercise_name
                            ],
                            'skill' => [
                                'id' => $value->skill_id,
                                'code' => $value->skill_code,
                                'name' => $value->skill_name
                            ],
                            'total_experience' => $value->total_experience
                        ];
                    }
                })->filter();
        });
    }
}
