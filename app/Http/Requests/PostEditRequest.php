<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:20'],
            'comment' => ['required', 'max:150'],
            // 特定のテーブルのカラムを使用して存在チェック
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}
