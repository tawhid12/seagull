<?php

namespace App\Http\Requests\BankDetail;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateBankDetailRequest extends FormRequest
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
    public function rules(Request $r)
    {
        $id=encryptor('decrypt',$r->uptoken);
        return [
            'bank_name'=>'required|unique:bank_details,bank_name,'.$id,
            'account_name'=>'required|unique:bank_details,account_name,'.$id,
            'account_no'=>'required|unique:bank_details,account_no,'.$id,
        ];
    }
    public function messages(){
        return [
            'required' => "The :attribute filed is required",
            'unique' => "The :attribute already used. Please try another",
        ];
    }
}
