<?php

namespace App\Http\Requests\Exercises;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Update exercise request",
 *      description="Store exercise request body data",
 *      type="object",
 *      required={"name"},
 *
 *      @OA\Property(
 *         property="name",
 *         title="name",
 *         example="Test some"
 *     ),
 * )
 */
class UpdateExerciseRequest extends FormRequest
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
            'name' => 'required|string|max:50',
        ];
    }
}
