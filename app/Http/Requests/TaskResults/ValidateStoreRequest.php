<?php

namespace App\Http\Requests\TaskResults;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ValidateStoreRequest extends FormRequest
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
    #[ArrayShape(['task_id' => "string", 'user_id' => "string", 'exercise_group_id' => "string", 'assessment' => "string"])]
    public function rules(): array
    {
        return [
            'task_id' => 'required|numeric|gte:1',
            'user_id' => 'required|numeric|gte:1',
            'exercise_group_id' => 'required|numeric|gte:1',
            'assessment' => 'required',
        ];
    }
}
