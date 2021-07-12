<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store task request",
 *      description="Store task request body data",
 *      type="object",
 *      required={"title"},
 *
 *      @OA\Property(
 *         property="title",
 *         title="title",
 *         example="Task. #3l7-5g5"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         title="description",
 *         example="Esse non nam voluptatibus beatae"
 *     ),
 *     @OA\Property(
 *         property="exercise_id",
 *         title="exercise_id",
 *         example="18"
 *     ),
 * )
 */
class UpdateTaskRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:50',
            'description' => 'string|max:500',
            'exercise_id' => 'integer',
        ];
    }
}
