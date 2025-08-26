@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h2">Create New User</h1>
        </div>

        <div class="card-body">
            <div class="col-lg-8"></div>
                <form action="/user" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">User Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter User Name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">User Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter User Email" id="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <a href="{{ route('user.index') }}" class="btn btn-outline-danger border-0 d-inline-flex align-items-center">
                        <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-outline-primary border-0 d-inline-flex align-items-center">
                        <i data-feather="user-plus" class="me-1" style="width:15px; height:15px;"></i> Create
                        User
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
