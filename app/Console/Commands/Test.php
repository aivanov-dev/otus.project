<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTaskResult;
use App\Models\Achievement;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Task;
use App\Models\TaskResult;
use App\Models\User;
use App\Services\SkillLevel\SkillLevelService;
use App\Services\UserProgressService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test {--Q|--queue=}';

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
    public function handle(UserProgressService $service, SkillLevelService $levelService)
    {
        $user = User::find(39);
        $tasks = TaskResult::query()->where('processed', false)->get()->count();

        Config::set('queue.default', 'sync');
        dd($this->option('queue'));
//        dd(config('queue'));
//        $a = Achievement::query()
//            ->whereDoesntHave('users', fn($query) => $query->where('id', '=', 4))
//            ->get();
//        dd($a->map(fn($a) => $a->id));
//        Experience::se
//tBindings([':initial' => 120])
//            ->where('user_id', 1)
//            ->where('skill_id', 1)
//            ->updateOrCreate([
//            'experience' => DB::raw(":initial")
//        ]);
//        dd(1);
        //        dd(env('RABBIT_MQ_ACHIEVEMENTS_QUEUE'));
//        dd(env('RABBIT_MQ_EXPERIENCE_QUEUE'));
        $result = TaskResult::query()->limit(1)->first();
//        $service->computeUserAchievements($result);
        dump($levelService->getLevelByExperience(501));
//        ProcessTaskResult::dispatch($result)->onQueue(env('RABBIT_MQ_EXPERIENCE_QUEUE'));
        return 0;
    }
}
