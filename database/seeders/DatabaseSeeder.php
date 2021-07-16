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
        $this->call(AchievementsTableSeeder::class);
        $this->call(ExerciseGroupSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(TaskResultSeeder::class);
    }
}
