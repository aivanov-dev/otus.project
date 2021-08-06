<?php

namespace App\Console\Commands;

use App\Models\Skill;
use App\Models\Task;
use App\Models\TaskResult;
use App\Models\User;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $result = TaskResult::find(8);
//        dump($result->skills->count());
        $task = Task::find(23);
//        dump($task->skills->count());
        dump(Skill::first()->tasks->count());
        return 0;
    }
}
