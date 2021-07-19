<?php

namespace Database\Seeders;

use App\Models\TaskResult;
use Illuminate\Database\Seeder;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\DB;

class TaskResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    #[NoReturn]
    public function run(): void
    {
        TaskResult::factory()->count(1000)->create();
    }
}
