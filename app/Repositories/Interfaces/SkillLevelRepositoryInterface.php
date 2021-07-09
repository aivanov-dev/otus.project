<?php


namespace App\Repositories\Interfaces;


interface SkillLevelRepositoryInterface
{
    public function all(): array;
    public function getLevelByValue(int $level): array;
}
