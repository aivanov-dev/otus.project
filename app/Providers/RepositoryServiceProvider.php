<?php

namespace App\Providers;

use App\Repositories\Interfaces\SkillLevelRepositoryInterface;
use App\Repositories\SkillLevelRepository;
use Illuminate\Support\ServiceProvider;

class   RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
    SkillLevelRepositoryInterface::class,
    SkillLevelRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
