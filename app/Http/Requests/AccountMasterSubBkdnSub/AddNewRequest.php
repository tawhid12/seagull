<?php

namespace App\Http\Requests\AccountMasterSubBkdnSub;

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
            'fcoa_bkdn_id'=>'required',
            'fcoa_bkdn_sub'=>'required|unique:account_master_sub_bkdn_subs,fcoa_bkdn_sub',
			'sub_code'=>'required|unique:account_master_sub_bkdn_subs,sub_code',
        ];
    }
    public function messages(){
        return [
            'required' => "The :attribute filed is required",
            'unique' => "The :attribute already used. Please try another",
        ];
    }
}
