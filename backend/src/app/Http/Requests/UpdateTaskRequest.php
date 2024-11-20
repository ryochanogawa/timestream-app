<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'due_date' => 'sometimes|nullable|date',
            'status' => 'sometimes|required|string|in:todo,in_progress,done',
            'priority' => 'sometimes|required|string|in:low,medium,high'
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => '有効なステータスを選択してください。'
        ];
    }
}
