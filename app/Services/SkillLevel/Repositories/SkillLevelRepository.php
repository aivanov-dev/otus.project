<?php


namespace App\Services\SkillLevel\Repositories;


interface SkillLevelRepository
{
    public function all(): array;

    public function getLevelByExperience(int $experience): array;

    public function findByName(string $name): array;
}
