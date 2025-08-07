@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-8">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h2">Create New Item</h1>
        </div>

        <div class="card-body">
            <div class="col-lg-12">
                <form action="/master/items" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                            id="description" value="{{ old('description') }}">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id"
                                id="category">
                                <option selected disabled value="">Choose Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
    
                        <div class="mb-3 col-md-4">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" value="{{ old('quantity') }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <a href="/master/items" class="btn btn-outline-danger border-0 d-inline-flex align-items-center">
                        <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-outline-primary border-0 d-inline-flex align-items-center">
                        <i data-feather="corner-down-right" class="me-1" style="width:15px; height:15px;"></i> Create Item
                    </button>
    
                </form>
            </div>
        </div>
        </div>
@endsection
