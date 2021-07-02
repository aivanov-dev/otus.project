<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

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
                return version_compare($item->{$property}, $value, $operator);
            });

            return $filteredCollection->count();
        });
    }
}
