<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customer.index', [
            'title' => 'Customer',
            'customers' => Customer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create', [
            'title' => 'Create Customer'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();

        // Auto generate code jika kosong / default "CUST-"
        if (!$request->filled('code') || $request->code === 'CUST-') {
            $lastCustomer = Customer::latest('id')->first();
            $nextId = $lastCustomer ? $lastCustomer->id + 1 : 1;
            $data['code'] = 'CUST-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        }

        Customer::create($data);

        return redirect()->route('customer.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'), [
            'title' => 'Edit Customer',
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->except('code');

        $customer->update($data);

        return redirect()->route('customer.index')->with('success', 'Customer Edited Successfullly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')->with('danger', 'Customer Deleted Successfully!');
    }
}
