<?php

namespace App\Http\Controllers;

use App\Models\OutgoingTransaction;
use Illuminate\Http\Request;

class OutgoingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('action.itemout.index', [
            'title' => 'Outgoing Transaction'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('action.itemout.create', [
            'title' => 'Outgoing Transaction'
        ]);
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
    public function show(OutgoingTransaction $outgoingTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingTransaction $outgoingTransaction)
    {
        return view('action.itemout.edit', [
            'title' => 'Outgoing Transaction'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutgoingTransaction $outgoingTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingTransaction $outgoingTransaction)
    {
        //
    }
}
