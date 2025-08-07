<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('master.category.index',[
            'title' => 'Category',
            'active' => 'Category',
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.category.create',[
            'title' => 'Create New Category'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedCategory = $request->validate([
            'category' => 'required|min:3'
        ]);

        $validatedCategory['name'] = $validatedCategory['category'];
        unset($validatedCategory['category']);

        Category::create($validatedCategory);

        return redirect()->route('category.index')->with('success', 'Category Created Sucessfully!');
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
    public function edit(Category $category)
    {
        return view('master.category.edit', [
            'title' => 'Edit Category',
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        // dd($request);

        $validated = $request->validate([
            'name' => 'required'
        ]);

        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Category Edited Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category )
    {
        $category->destroy($category->id);

        return redirect()->route('category.index')->with('danger', 'Category Deleted Successfully!');
    }
}
