<?php


namespace App\Services\SkillLevel\Repositories;


use Illuminate\Support\Collection;

class LocalSkillLevelRepository implements SkillLevelRepository
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

    public function findByName(string $name): array
    {
        return Collection::make($this->all())->first(fn(array $level) => $name === $level['name']);
    }

    public function getLevelByExperience(int $experience): array
    {
        return Collection::make($this->all())
            ->takeUntil(fn(array $level) => $experience <= $level['experience'])
            ->last();
    }
}
