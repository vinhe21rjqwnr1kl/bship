<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlashSaleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'type' => '',
            'start_date' => 'required',
            'end_date' => 'required',
            'status' => '',
            'data' => '',
            'discounts' => 'array',
//            'discounts.*.type' => 'required',
//            'discounts.*.max_usage' => 'required|integer|min:1',
//            'discounts.*.status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => ':attribute là bắt buộc.',
            'status.required' => ':attribute là bắt buộc.',
            'type.required' => ':attribute là bắt buộc.',
            'start_date.required' => ':attribute là bắt buộc.',
            'end_date.required' => ':attribute là bắt buộc.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'status' => 'Trạng thái',
            'type' => 'Loại',
            'start_date' => 'Thời gian bắt đầu',
            'end_date' => 'Thời gian kết thúc',
        ];
    }
}
