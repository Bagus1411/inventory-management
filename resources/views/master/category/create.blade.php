@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h2">Create New Category</h1>
        </div>

        <div class="card-body">
            <div class="col-lg-8">
                <form action="/master/category" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Category Name</label>
                        <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                            id="category" value="{{ old('category') }}">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <a href="/master/category" class="btn btn-outline-danger border-0 d-inline-flex align-items-center">
                        <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-outline-primary border-0 d-inline-flex align-items-center">
                        <i data-feather="corner-down-right" class="me-1" style="width:15px; height:15px;"></i> Edit Category
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
