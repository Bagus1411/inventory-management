<?php

namespace App\Http\Controllers;

use App\Models\IncomingTransaction;
use Illuminate\Http\Request;

class IncomingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inout.in.index', [
            'title' => 'ItemIn',
            'active' => 'ItemIn'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingTransaction $incomingTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomingTransaction $incomingTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomingTransaction $incomingTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingTransaction $incomingTransaction)
    {
        //
    }
}
