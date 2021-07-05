<?php

namespace App\Http\Requests\Achievements;

use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Foundation\Http\FormRequest;

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

    #[ArrayShape(['page' => "string", 'per-page' => "string", 'offset' => "string"])]
    public function rules(): array
    {
        return [
            'page' => 'sometimes|required|numeric|gte:1',
            'per-page' => 'sometimes|required|numeric|gte:1',
        ];
    }

//    #[ArrayShape(['page' => "string", 'per-page' => "string"])]
//    public function messages(): array
//    {
//        return [
//            'page' => 'If page is present it must be numeric and greater than 0!',
//            'per-page' => 'If per-page is present it must be numeric and greater than 0!',
//        ];
//    }
}
