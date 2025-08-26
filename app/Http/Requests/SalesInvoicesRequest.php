<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SalesInvoicesRequest extends FormRequest
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

        $diabaikan = optional($this->route('sale'))->id;        // dd($this->route('sale'), $this->route('sales'));


        return [
            'number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sales_invoices', 'number')->ignore($diabaikan)
            ],
            'customer_id' => [
                'required',
                'exists:customers,id'
            ],
            'date' => [
                'required',
                'date'
            ],
            'description' => [
                'nullable',
                'string',
                'max:255'
            ],
            'total' => [
                'required',
                'decimal:0,2'
            ],
            'items.*.item_id' => [
                'required',
                'exists:items,id'
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'items.*.price' => [
                'required',
                'decimal:0,2',
                'min:1'
            ],
            'items.*.discount_percent' => [
                'required',
                'decimal:0,2'
            ],
            // 'items.*.discount_amount' => [
            //     'required',
            //     'decimal'
            // ],
            'items.*.note' => [
                'nullable',
                'string',
                'max:255'
            ],
            // 'items.*.subtotal' => [
            //     'required',
            //     'decimal'
            // ],
            // 'items.*.total' => [
            //     'required',
            //     'decimal'
            // ],

            'discount_global' => [
                'required',
                'decimal:0,2'
            ],
            // 'discount_global2' => [
            //     'required',
            //     'decimal'
            // ],
            'ppn' => [
                'required',
                'decimal:0,2'
            ],
            // 'ppn2' => [
            //     'required',
            //     'decimal'
            // ],
            // 'total_item_value' => [
            //     'required',
            //     'decimal'
            // ],
            // 't_a_g_d' => [
            //     'required',
            //     'decimal'
            // ],
            'grand_total' => [
                'required',
                'decimal:0,2'
            ]
        ];
    }
}



