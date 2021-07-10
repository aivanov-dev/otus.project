<?php


namespace App\Repositories;


use App\Repositories\Interfaces\SkillLevelRepositoryInterface;

class SkillLevelRepository implements SkillLevelRepositoryInterface
{
    private const Levels = [
        ['name' => 'A1 - Beginner', 'experience' => 0],
        ['name' => 'A2 - Elementary', 'experience' => 100],
        ['name' => 'B1 - Intermediate', 'experience' => 200],
        ['name' => 'B2 - Upper-Intermediate', 'experience' => 300],
        ['name' => 'C1 - Advanced', 'experience' => 400],
        ['name' => 'C2 - Proficiency', 'experience' => 500]
    ];

    public function all(): array
    {
        return self::Levels;
    }

    public function getLevelByExperience(int $experience): array
    {
        $closestLevel = null;
        $result = null;

        foreach (self::Levels as $key => $value) {
            if ($closestLevel === null || abs($experience - $closestLevel) > abs( $value['experience'] - $experience)) {
                $closestLevel = $value['experience'];
                $result = self::Levels[$key];
            }
        }

        return $result;
    }
}
