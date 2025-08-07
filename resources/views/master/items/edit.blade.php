@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-8">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h2">Edit Items</h1>
        </div>

        <div class="card-body">
            <div class="col-lg-11">
                <form action="{{ route('items.update', $items->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Item Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name', $items->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description"
                            class="form-control @error('description') is-invalid @enderror" id="description"
                            value="{{ old('description', $items->description) }}">
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id"
                                id="category">
                                <option selected disabled value="" hidden>Choose Category</option>
                                @foreach ($categories as $category)
                                    {{-- @if (old('category_id', $items->category_id) == $category->id)
                                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                        @else
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif --}}
                                    <option value="{{ $category->id }}" @selected(old('category_id', $items->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="stock" class="form-label">Quantity</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                id="stock" value="{{ old('stock', $items->stock) }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="/master/items"
                                class="btn btn-outline-danger border-0 d-inline-flex align-items-center">
                                <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                            </a>
                            <button type="submit"
                                class="btn btn-outline-primary border-0 d-inline-flex align-items-center">
                                <i data-feather="corner-down-right" class="me-1" style="width:15px; height:15px;"></i>
                                Edit Item
                            </button>
                        </div>

                </form>

                <!-- Form Delete (tetap di dalam card, tapi DI LUAR form edit) -->
                <form action="{{ route('items.destroy', $items->id) }}" method="POST" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger border-0"
                        onclick="return confirm('Are you sure want to delete this Item?')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
