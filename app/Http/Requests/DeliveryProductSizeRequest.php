<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryProductSizeRequest extends FormRequest
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
            'name' => ['required', 'regex:/^[^\d]+$/u', 'string', Rule::unique('delivery_product_size')->ignore($id)],
            'ratio' => ['required', 'numeric'],
            'length' => ['required', 'numeric'],
            'width' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường :attribute là bắt buộc',
            'name.regex' => 'Định dạng :attribute không hợp lệ',
            'name.unique' => ':attribute đã được sử dụng',
            'ratio.required' => 'Trường :attribute là bắt buộc',
            'ratio.numeric' => ':attribute phải là một số',
            'length.required' => 'Trường :attribute là bắt buộc',
            'length.numeric' => ':attribute phải là một số',
            'width.required' => 'Trường :attribute là bắt buộc',
            'width.numeric' => ':attribute phải là một số',
            'height.required' => 'Trường :attribute là bắt buộc',
            'height.numeric' => ':attribute phải là một số',
            'weight.required' => 'Trường :attribute là bắt buộc',
            'weight.numeric' => ':attribute phải là một số',

        ];
    }

    public function attributes()
    {
        return [
            'name'=> 'tên',
            'ratio'=> 'tỉ lệ',
            'length'=> 'chiều dài',
            'width'=> 'chiều rộng',
            'height'=> 'chiều cao',
            'weight'=> 'cân nặng',
        ];
    }

    protected function prepareForValidation()
    {
        // Chuyển đổi giá trị của trường 'name' thành chữ hoa
        $this->merge([
            'name' => strtoupper($this->name),
        ]);

        parent::prepareForValidation();
    }
}
