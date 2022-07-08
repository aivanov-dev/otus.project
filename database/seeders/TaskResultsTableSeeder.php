<?php

namespace Database\Seeders;

use App\Models\TaskResult;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
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
        Collection::times(1000)->each(fn() => TaskResult::factory()->create());
    }
}
