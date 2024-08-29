<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TouristDestinationRequest extends FormRequest
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
            'index' => 'required|regex:/^[0-9]+$/',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'limit_radius' => 'required|numeric',
            'data' => '',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => ':attribute là bắt buộc.',
            'status.required' => ':attribute là bắt buộc.',
            'index.required' => ':attribute là bắt buộc.',
            'latitude.required' => ':attribute là bắt buộc.',
            'longitude.required' => ':attribute là bắt buộc.',
            'limit_radius.required' => ':attribute là bắt buộc.',
            'index.regex' => ':attribute không hợp lệ.',
            'latitude.regex' => ':attribute không hợp lệ.',
            'longitude.regex' => ':attribute không hợp lệ.',
            'limit_radius.regex' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'status' => 'Trạng thái',
            'index' => 'Thứ tự',
            'latitude' => 'Vĩ độ',
            'longitude' => 'Kinh độ',
            'limit_radius' => 'Giới hạn bán kính',
        ];
    }
}
