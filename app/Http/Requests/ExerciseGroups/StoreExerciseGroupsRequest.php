<?php

namespace App\Http\Requests\ExerciseGroups;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store exercise groups request",
 *      description="Store exercise groups request body data",
 *      type="object",
 *      required={"name"},
 *
 *      @OA\Property(
 *         property="name",
 *         title="name",
 *         example="English"
 *     ),
 * )
 */
class StoreExerciseGroupsRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'id' => 'integer|min:1',
        ];
    }
}
