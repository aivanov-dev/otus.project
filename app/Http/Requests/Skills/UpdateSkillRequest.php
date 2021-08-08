<?php

namespace App\Http\Requests\Skills;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Update skill request",
 *      description="Update skill request body data",
 *      type="object",
 *
 *      @OA\Property(
 *          property="name",
 *          title="name",
 *          description="New name of the skill",
 *          example="Чтение"
 *      ),
 *
 *      @OA\Property(
 *          property="code",
 *          title="code",
 *          description="New code of the skill",
 *          example="reading"
 *      ),
 * )
 */
class UpdateSkillRequest extends FormRequest
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
            'name' => 'required_without:code|string|max:32',
            'code' => 'required_without:name|string|max:32'
        ];
    }
}
