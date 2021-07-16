<?php

namespace App\Http\Requests\TaskResults;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ValidateIndexRequest extends FormRequest
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
    #[ArrayShape(['page' => "string", 'per-page' => "string"])]
    public function rules(): array
    {
        return [
            'page' => 'sometimes|required|numeric|gte:1',
            'per-page' => 'sometimes|required|numeric|gte:1',
        ];
    }
}
