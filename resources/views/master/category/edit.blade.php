@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h2">Edit Category</h1>
        </div>

        <div class="card-body">
            <div class="col-lg-8">
                <form action="{{ route('category.update', $category->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name', $category->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="/master/category" class="btn btn-outline-danger border-0 d-inline-flex align-items-center"> 
                                <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-outline-primary border-0 d-inline-flex align-items-center">
                                <i data-feather="corner-down-right" class="me-1" style="width:15px; height:15px;"></i> Edit Category
                            </button>
                        </div>

                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger border-0"
                                onclick="return confirm('Are you sure want to delete this Category?')">
                                <i data-feather="trash-2"></i>
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
