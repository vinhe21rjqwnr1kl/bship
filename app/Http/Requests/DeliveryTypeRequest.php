<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryTypeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('id');
        return [
            'name' => ['required', 'string', Rule::unique('delivery_type')->ignore($id)],
            'ratio' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường :attribute là bắt buộc',
            'name.unique' => ':attribute đã được sử dụng',
            'ratio.required' => 'Trường :attribute là bắt buộc',
            'ratio.numeric' => ':attribute phải là một số',
        ];
    }

    public function attributes()
    {
        return [
            'name'=> 'tên',
            'ratio'=> 'tỉ lệ',
        ];
    }
}
