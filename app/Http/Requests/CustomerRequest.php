<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $ignore = $this->route('customer');
        
        return [
            // 'code' => [
            //   'required',  
            //   'string',
            //   'max:50',
            //   Rule::unique('customers', 'code')->ignore($ignore)
            // ],
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('customers', 'name')->ignore($ignore)
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('customers', 'email')->ignore($ignore)
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:50',
            'province' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:10',
            'status' => 'required|integer',
        ];
    }
}
