<?php

namespace App\Rules;

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
    #[Pure]
    public function passes($attribute, $value): bool
    {
        foreach (['save', 'update', 'create', 'make', 'delete', 'push'] as $needle) {
            if (Str::contains($value, $needle)) {
                return false;
            }
        }

        return true;
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
