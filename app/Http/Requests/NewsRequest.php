<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'status' => 'required',
            'find_index' => 'required|regex:/^[0-9]+$/',
            'news_url' => '',
            'data' => '',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => ':attribute là bắt buộc.',
            'status.required' => ':attribute là bắt buộc.',
            'find_index.required' => ':attribute là bắt buộc.',
            'find_index.regex' => ':attribute phải là số.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'status' => 'Trạng thái',
            'find_index' => 'Thứ tự',
        ];
    }
}
