<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class AddOrderRequest extends FormRequest
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
            'order_subject' => 'required',
            'invoice_no' => 'nullable|unique:orders,invoice_no,',
            'po_no' => 'nullable|unique:orders,po_no,',
            'client_id' => 'required',
            'vessel_id' => 'required',
            'currency' => 'required',
            'amount' => 'required|numeric|gt:0',
        ];
    }
    public function messages()
    {
        return [
            'required' => "The :attribute filed is required",
            'unique' => "The :attribute already used. Please try another",
            'numeric' => 'The :attribute must be a number.',
            'gt' => [
                'numeric' => 'The :attribute must be greater than :value.',
            ],
        ];
    }
}
