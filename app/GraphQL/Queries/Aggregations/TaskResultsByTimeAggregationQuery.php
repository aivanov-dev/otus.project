<?php


namespace App\GraphQL\Queries\Aggregations;

use App\Models\TaskResult;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\Type as GraphQLType;
use Illuminate\Support\Facades\Cache;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class TaskResultsByTimeAggregationQuery extends Query
{
    public function type(): Type
    {
        return GraphQLType::listOf(GraphQL::type('TaskResultByTimeAggregation'));
    }

    public function args(): array
    {
        return [
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int(),
                'rules' => ['required']
            ],
            'date_from' => [
                'name' => 'date_from',
                'type' => Type::string(),
                'rules' => ['required', 'date_format:Y-m-d']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        return Cache::remember('TaskResultByTimeAggregation', now()->addMinutes(250), function () use ($args) {
            return TaskResult::query()
                ->select(
                    'users.id as user_id',
                    'users.name as user_name',
                    'skills.id as skill_id',
                    'skills.name as skill_name',
                    \DB::raw('SUM(task_results.assessment) as total_assessment')
                )
                ->leftJoin('users', 'users.id', '=', 'task_results.user_id')
                ->leftJoin('tasks', 'tasks.id', '=', 'task_results.task_id')
                ->leftJoin('influences', 'influences.task_id', '=', 'tasks.id')
                ->leftJoin('skills', 'skills.id', '=', 'influences.skill_id')
                ->where('task_results.created_at', '>=', $args['date_from'])
                ->where('task_results.user_id', '=', $args['user_id'])
                ->groupBy('skills.id', 'users.id')
                ->orderBy('total_assessment', 'DESC')
                ->get()
                ->map(function ($value) {
                    return [
                        'user' => [
                            'id' => $value->user_id,
                            'name' => $value->user_name
                        ],
                        'skill' => [
                            'id' => $value->skill_id,
                            'name' => $value->skill_name
                        ],
                        'total_assessment' => $value->total_assessment
                    ];
                });
        });
    }
}
