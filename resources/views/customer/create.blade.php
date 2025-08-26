@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-8">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h2">Create New Customer</h1>
        </div>

        <div class="card-body">
            <div class="col-lg-12">
                <form action="/customer" method="post">
                    @csrf

                    {{-- Code --}}
                    {{-- <div class="mb-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                id="code" value="{{ old('code') }}" value="{{ old('code', 'CUST-') }}"
                                placeholder="Enter customer code (e.g., CUST-001)">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}

                    {{-- Name & Email --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Customer Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" placeholder="Enter customer name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email') }}" placeholder="Enter customer email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone & Address --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                id="address" value="{{ old('address') }}" placeholder="Enter full address">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- City & Province --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                                id="city" value="{{ old('city') }}" placeholder="Enter city">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" name="province"
                                class="form-control @error('province') is-invalid @enderror" id="province"
                                value="{{ old('province') }}" placeholder="Enter province">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Postal Code (sendiri, 1/3) & Status (opsional) --}}
                    <div class="row g-3 mt-0">
                        <div class="col-md-4">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="number" name="postal_code" id="postal_code"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                value="{{ old('postal_code') }}" placeholder="Enter Postal Code">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" @selected(old('status', '1') == '1')>Active</option>
                                <option value="0" @selected(old('status') == '0')>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- Buttons --}}
                    <div class=" mt-4">
                        <a href="{{ route('customer.index') }}"
                            class="btn btn-outline-danger border-0 d-inline-flex align-items-center">
                            <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-outline-primary border-0 d-inline-flex align-items-center">
                            <i data-feather="user-plus" class="me-1" style="width:15px; height:15px;"></i> Create
                            Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
