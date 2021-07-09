<?php


namespace App\Repositories;


use App\Repositories\Interfaces\SkillLevelRepositoryInterface;

class SkillLevelRepository implements SkillLevelRepositoryInterface
{
    private const Levels = [
        ['name' => 'A1 - Beginner', 'level' => 0],
        ['name' => 'A2 - Elementary', 'level' => 100],
        ['name' => 'B1 - Intermediate', 'level' => 200],
        ['name' => 'B2 - Upper-Intermediate', 'level' => 300],
        ['name' => 'C1 - Advanced', 'level' => 400],
        ['name' => 'C2 - Proficiency', 'level' => 500]
    ];

    public function all(): array
    {
        return self::Levels;
    }

    public function getLevelByValue(int $level): array
    {
        $closestLevel = null;
        $result = null;

        foreach (self::Levels as $key => $value) {
            if ($closestLevel === null || abs($level - $closestLevel) > abs( $value['level'] - $level)) {
                $closestLevel = $value['level'];
                $result = self::Levels[$key];
            }
        }

        return $result;
    }
}
