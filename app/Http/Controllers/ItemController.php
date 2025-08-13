<?php

namespace App\Http\Controllers;
use App\Models\Item;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.items.index', [
            'title' => 'Items',
            'active' => 'Items',
            'items' => Item::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.items.create', [
            'title' => 'Create Item',
            'items' => Item::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {   

        // $validatedItem = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'category_id' => 'required|exists:categories,id',
        //     'description' => 'required',
        //     'quantity' => 'required|integer|min:1'
        // ]);

        // dd($validatedItem);

        Item::create($request->validated());

        return redirect()->route('items.index')->with('success', 'Item Created Succesfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('master.items.edit', [
            'title' => 'Edit Items',
            'items' => $item,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, Item $item)
    {

        // dd($request);

        // $validatedItems = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'category_id' => 'required|exists:categories,id',
        //     'description' => 'required',
        //     'stock' => 'required|integer|min:1'
        // ]);

        $item->update($request->validated());

        return redirect()->route('items.index')->with('success', 'Item Edited Succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->destroy($item->id);

        return redirect()->route('items.index')->with('danger', "Item Deleted Succesfully!");
    }
}
