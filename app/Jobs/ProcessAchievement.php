<?php

namespace App\Jobs;

use App\Models\TaskResult;
use App\Services\UserProgressService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessAchievement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TaskResult
     */
    public TaskResult $taskResult;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TaskResult $taskResult)
    {
        $this->taskResult = $taskResult;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserProgressService $service)
    {
        $service->computeUserAchievements($this->taskResult);
    }
}
