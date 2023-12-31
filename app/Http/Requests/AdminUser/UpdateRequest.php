<?php

namespace App\Http\Requests\AdminUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class UpdateRequest extends FormRequest
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
            'userName'=>'required',
            'role_id'=>'required_if:permission_type,1',
            //'multiple_role_id'=>'required_if:permission_type,2',
            'userEmail'=>'nullable|unique:users,email,'.$id,
            'contactNumber'=>'required|unique:users,contact_no,'.$id
        ];
    }

    public function messages(){
        return [
            'required' => "The :attribute filed is required",
            'unique' => "The :attribute already used. Please try another",
        ];
    }
}
