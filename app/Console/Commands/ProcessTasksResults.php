<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTaskResult;
use App\Models\TaskResult;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class ProcessTasksResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task_results:process {--Q|--queue=} {--D|--display-connection} {--L|--log-tasks}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all unprocessed task\'s results';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $connection = $this->option('queue') ?? config('queue.default');
        $logging = $this->option('log-tasks');
        if ($this->option('display-connection')) {
            $this->info("Tasks will be processed through {$connection} connection");
        }
        $self = $this;
        TaskResult::query()->where('processed', false)->get()->each(static function (TaskResult $result) use ($connection, $logging, $self) {
            if ($logging) {
                $self->warn("Try to process {$result->name}[{$result->getKey()}] result");
            }
            ProcessTaskResult::dispatch($result)
                ->onConnection($connection)
                ->onQueue(env('RABBIT_MQ_EXPERIENCE_QUEUE'));
            if ($logging) {
                $self->info("Result is dispatched");
            }
        });
    }
}
