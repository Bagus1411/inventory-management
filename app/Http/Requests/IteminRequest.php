<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class IteminRequest extends FormRequest
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

        $diabaikan = $this->route('itemin');

        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('incoming_transaction', 'code')->ignore($diabaikan)
            ],
            'note' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'created_by' => ['nullable', 'string', 'max:255'],

            // Relasi items
            'items' => ['nullable', 'array'],
            'items.*.item_id' => ['required_with:items.*'],
            // 'items.*.category_id' => ['required_with:items.*', 'exists:categories,id'],
            'items.*.quantity' => ['required_with:items.*', 'integer', 'min:1'],
            'items.*.note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
