<?php


namespace App\Repositories\Interfaces;


interface SkillLevelRepositoryInterface
{
    public function all(): array;
    public function getLevelByExperience(int $experience): array;
}
