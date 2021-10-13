<?php

namespace Database\Seeders;

use App\Models\TaskResultStatistics;
use Illuminate\Database\Seeder;

class TaskResultStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskResultStatistics::factory()->count(100)->create();
    }
}
