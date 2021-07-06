<?php

namespace App\Http\Requests\Achievements;

use JetBrains\PhpStorm\ArrayShape;
use App\Rules\SafeExpressionLanguage;
use Illuminate\Foundation\Http\FormRequest;

class ValidateUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['name' => "string", 'slug' => "string", 'description' => "string", 'expression' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|nullable|string',
            'slug' => 'sometimes|required|nullable|string',
            'description' => 'sometimes|required|nullable|string',
            'expression' => ['sometimes', 'required', 'nullable', 'string', new SafeExpressionLanguage()]
        ];
    }
}
