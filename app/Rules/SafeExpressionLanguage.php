<?php

namespace App\Rules;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Illuminate\Contracts\Validation\Rule;

class SafeExpressionLanguage implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !$this->prohibitedActions()->contains(Str::lower($value));
    }

    public function prohibitedActions(): Collection
    {
        return Collection::make([
            'save', 'update', 'create', 'make', 'delete', 'push'
        ]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Expression language statement must not contain save, update, create, make, delete and push keywords for safety reasons!';
    }
}
