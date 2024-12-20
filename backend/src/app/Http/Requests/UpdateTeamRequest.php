<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * チーム更新のリクエスト
 */
class UpdateTeamRequest extends FormRequest
{
    /**
     * チーム更新の認証
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * チーム更新のバリデーションルール
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ];
    }

    /**
     * チーム更新のバリデーションメッセージ
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.max' => 'チーム名は255文字以内で入力してください',
        ];
    }
}
