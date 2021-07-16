<?php

namespace App\Services;

use Exception;
use App\Models\TaskResult;
use App\Models\Experience;
use App\Models\Achievement;
use App\Jobs\ResultSavedJob;
use App\Events\ResultSavedEvent;
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
     * @param ResultSavedEvent $event
     *
     * @throws Exception
     */
    public function checkUserProgress(ResultSavedEvent $event): void
    {
        if ($event->jobName === ResultSavedJob::class && $event->queueName === $_ENV['RABBIT_MQ_ACHIEVEMENTS_QUEUE']) {
            $this->computeUserAchievements($event->taskResult);
            return ;
        }

        if ($event->jobName === ResultSavedJob::class && $event->queueName === $_ENV['RABBIT_MQ_EXPERIENCE_QUEUE']) {
            $this->computeUserExperience($event->taskResult);
            return ;
        }


        throw new Exception("ResultSavedJob must come from {$_ENV['RABBIT_MQ_ACHIEVEMENTS_QUEUE']} or {$_ENV['RABBIT_MQ_EXPERIENCE_QUEUE']} queues only!");
    }

    /**
     * @param TaskResult $taskResult
     */
    private function computeUserAchievements(TaskResult $taskResult): void
    {
        Achievement::chunk(100, function ($achievements) use ($taskResult) {
            foreach ($achievements as $achievement) {
                if ($this->expressionLanguage->evaluate($achievement->expression, ['taskResult' => $taskResult])) {
                    $taskResult->user()->first()->achievements()->syncWithoutDetaching([$achievement->id]);
                }
            }
        });
    }

    /**
     * @param TaskResult $taskResult
     */
    private function computeUserExperience(TaskResult $taskResult): void
    {
        $taskInfluences = $taskResult->task->influences;
        foreach ($taskInfluences as $taskInfluence) {
            Experience::updateOrCreate(
                ['user_id' => $taskResult->user_id, 'skill_id' => $taskInfluence->skill_id],
                ['experience' => $taskResult->assessment * $taskInfluence->value / 100]
            );
        }
    }
}
