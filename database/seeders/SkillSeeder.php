<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collection::make([
            'reading'   => 'Письмо',
            'listening' => 'Аудирование',
            'grammar'   => 'Грамматика',
            'speaking'  => 'Говорение',
            'writing'   => 'Чтение',
        ])->each(fn($item, $key) => Skill::create([
            'code' => $key,
            'name' => $item
        ]));
    }
}
