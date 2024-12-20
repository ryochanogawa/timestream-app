<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * チーム作成のリクエスト
 */
class CreateTeamRequest extends FormRequest
{
    /**
     * チーム作成の認証
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // 後で認証を実装する際に修正
    }

    /**
     * チーム作成のバリデーションルール
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    /**
     * チーム作成のバリデーションメッセージ
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'チーム名は必須です',
            'name.max' => 'チーム名は255文字以内で入力してください',
        ];
    }
}
