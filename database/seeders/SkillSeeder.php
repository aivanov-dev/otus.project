<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::upsert([
            ['code' => 'reading', 'name' => 'Чтение'],
            ['code' => 'writing', 'name' => 'Письмо'],
            ['code' => 'speaking', 'name' => 'Говорение'],
            ['code' => 'listening', 'name' => 'Аудирование'],
            ['code' => 'grammar', 'name' => 'Грамматика']
        ], ['code'], ['name']);
    }
}
