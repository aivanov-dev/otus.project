<?php


namespace App\Services\SkillLevel;


use App\Services\SkillLevel\Repositories\SkillLevelRepository;
use Illuminate\Support\Collection;

class SkillLevelService
{
    public function __construct(private SkillLevelRepository $repository)
    {

    }

    public function all(): array
    {
        return $this->repository->all();
    }


    public function getLevelByExperience(int $experience): array
    {
        return $this->repository->getLevelByExperience($experience);
    }
}
