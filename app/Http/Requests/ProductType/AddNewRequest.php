<?php

namespace App\Http\Requests\ProductType;

use Illuminate\Foundation\Http\FormRequest;

class AddNewRequest extends FormRequest
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
        return [
            'product_type_name'=>'required|unique:product_types,product_type_name',
        ];
    }
    public function messages(){
        return [
            'required' => "The :attribute filed is required",
            'unique' => "The :attribute already used. Please try another",
        ];
    }
}
