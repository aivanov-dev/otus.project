<?php

namespace App\Providers;

use App\Services\SkillLevel\Repositories\LocalSkillLevelRepository;
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
            \App\Services\SkillLevel\Repositories\SkillLevelRepository::class,
            LocalSkillLevelRepository::class
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
