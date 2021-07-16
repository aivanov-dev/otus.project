<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AchievementsTableSeeder::class);
        $this->call(ExerciseGroupSeeder::class);
        $this->call(TaskResultsTableSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(TaskSeeder::class);
    }
}
