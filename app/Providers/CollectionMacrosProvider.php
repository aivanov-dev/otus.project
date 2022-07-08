<?php


namespace App\Providers;


use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class CollectionMacrosProvider extends ServiceProvider
{
    public function boot()
    {
        $this->addCountWithCondition();
    }

    private function addCountWithCondition(): void
    {
        Collection::macro('countWithCondition', function (string $property, string $value, string $operator = '==') {
            /**@var Collection $this*/
            return $this->filter(fn($item) => version_compare((float)$item->{$property}, (float)$value, $operator))->count();
        });
    }
}
