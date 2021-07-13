<?php

namespace App\Events;

use App\Models\TaskResult;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ResultSavedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public string $jobName;

    /**
     * @var string
     */
    public string $queueName;

    /**
     * @var TaskResult
     */
    public TaskResult $taskResult;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $jobName, string $queueName, TaskResult $taskResult)
    {
        $this->jobName = $jobName;
        $this->queueName = $queueName;
        $this->taskResult = $taskResult;
    }
}
