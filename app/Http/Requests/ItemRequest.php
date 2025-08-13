<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
        $ignore = $this->route('item');

        return [
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('items', 'name')->ignore($ignore)
        ],
        'category_id' => [
            'required',
            // Rule::exists('items', 'category_id')
        ],
        'description' => ['required'],
        'stock' => ['required', 'integer', 'min:1']
        ];
    }
}
