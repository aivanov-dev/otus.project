<?php

namespace App\Http\Requests\Skills;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store skill request",
 *      description="Store skill request body data",
 *      type="object",
 *      required={"name", "code"},
 *
 *      @OA\Property(
 *         property="name",
 *         title="name",
 *         example="Письмо"
 *     ),
 *
 *     @OA\Property(
 *         property="code",
 *         title="code",
 *         example="writing"
 *     ),
 * )
 */
class StoreSkillRequest extends FormRequest
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
            'name' => 'required|string|max:32',
            'code' => 'required|string|max:32|unique:App\Models\Skill'
        ];
    }
}
