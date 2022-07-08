<?php

namespace App\Services;

use App\Models\TaskResult;
use App\Models\Experience;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class UserProgressService
{
    /**
     * @var ExpressionLanguage
     */
    private ExpressionLanguage $expressionLanguage;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ExpressionLanguage $expressionLanguage)
    {
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * @param TaskResult $taskResult
     */
    public function computeUserAchievements(TaskResult $taskResult): void
    {
        Achievement::query()
            ->whereDoesntHave('users', fn(Builder $query) => $query->where('id', '=', $taskResult->user->getKey()))
            ->chunk(50, fn(Collection $achievements) => $achievements->each(function (Achievement $achievement) use ($taskResult) {
                if ($this->expressionLanguage->evaluate($achievement->expression, ['taskResult' => $taskResult])) {
                    $taskResult->user()->first()->achievements()->syncWithoutDetaching([$achievement->getKey()]);
                }
            }));
    }

    /**
     * @param TaskResult $taskResult
     */
    public function computeUserExperience(TaskResult $taskResult): void
    {
        $taskInfluences = $taskResult->task->influences;
        foreach ($taskInfluences as $taskInfluence) {
            if (!$taskResult->processed) {
                Experience::firstOrCreate(
                    ['user_id' => $taskResult->user_id, 'skill_id' => $taskInfluence->skill_id],
                    ['experience' => 0]
                )->increment('experience', $taskResult->assessment * $taskInfluence->value / 100);
                $taskResult->update(['processed' => true]);
            }
        }
    }
}
