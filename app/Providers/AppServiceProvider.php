<?php

namespace App\Providers;

use App\Events\ResultSavedEvent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addNewCollectionMacros();
    }

    /**
     * Collection method "countWithCondition" can be used in achievement setup.
     *
     * @return void
     */
    private function addNewCollectionMacros(): void
    {
        Collection::macro('countWithCondition', function (string $property, string $value, string $operator = '==') {
            $filteredCollection = $this->filter(function ($item, $key) use ($property, $value, $operator) {
                return version_compare((float)$item->{$property}, (float)$value, $operator);
            });

            return $filteredCollection->count();
        });
    }
}
