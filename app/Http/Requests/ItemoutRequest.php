<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ItemoutRequest extends FormRequest
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

        $ignore = $this->route('itemout');

        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('outgoing_transaction', 'code')->ignore($ignore)
            ],
            'note' => [
                'nullable',
                'string',
                'max:255'
            ],
            'date' => [
                'required',
                'date'
            ],
            'items' => [
                'required',
                'array',
                'min:1'
            ],
            'created_by' => [
                'required',
                'string',
                'max:255'
            ],
            'items.*.item_id' => [
                'required',
            ],
            // 'items.*.category_id' => 'required|exists:categories,id',
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'items.*.note' => [
                'nullable',
                'string',
                'max:255'
            ]
            
        ];
    }
}
