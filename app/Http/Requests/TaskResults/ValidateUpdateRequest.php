<?php

namespace App\Http\Requests\TaskResults;

use JetBrains\PhpStorm\ArrayShape;
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
    #[ArrayShape(['task_id' => "string", 'user_id' => "string", 'exercise_group_id' => "string", 'assessment' => "string"])]
    public function rules(): array
    {
        return [
            'task_id' => 'sometimes|required|string',
            'user_id' => 'sometimes|required|string',
            'exercise_group_id' => 'sometimes|required|string',
            'assessment' => 'sometimes|required',
        ];
    }
}
