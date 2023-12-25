<?php

namespace App\Http\Requests\BankDetail;

use Illuminate\Foundation\Http\FormRequest;

class AddBankDetailRequest extends FormRequest
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
            //'bank_name'=>'required|unique:bank_details,bank_name',
            //'account_name'=>'required|unique:bank_details,account_name',
            'account_no'=>'required|unique:bank_details,account_no',
        ];
    }
    public function messages(){
        return [
            'required' => "The :attribute filed is required",
            'unique' => "The :attribute already used. Please try another",
        ];
    }
}
