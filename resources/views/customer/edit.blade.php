@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-8">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="h2">Edit Customer</h1>
        </div>

        <div class="card-body">
            <div class="col-lg-12">
                <form action="{{ route('customer.update', $customer->id) }}" method="post">
                    @method('put')
                    @csrf
                    {{-- Code --}}
                    {{-- <div class="mb-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                            id="code" value="{{ old('code', $customer->code) }}" >
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
                                id="name" placeholder="Enter Customer Name" value="{{ old('name', $customer->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder="Enter Customer Email" value="{{ old('email', $customer->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone & Address --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" placeholder="Enter phone number" value="{{ old('phone', $customer->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                id="address" placeholder="Enter full address" value="{{ old('address', $customer->address) }}">
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
                                id="city" placeholder="Enter city" value="{{ old('city', $customer->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" name="province"
                                class="form-control @error('province') is-invalid @enderror" id="province"
                                placeholder="Enter province" value="{{ old('province', $customer->province) }}">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Postal Code (sendiri, 1/3) & Status (opsional) --}}
                    <div class="row g-3 mt-0">
                        <div class="col-md-4">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code"
                                class="form-control @error('postal_code') is-invalid @enderror"
                                placeholder="Enter Postal Code" value="{{ old('postal_code', $customer->postal_code) }}">
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

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <a href="{{ route('customer.index') }}"
                                class="btn btn-outline-danger border-0 d-inline-flex align-items-center">
                                <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                            </a>
                            <button type="submit"
                                class="btn btn-outline-primary border-0 d-inline-flex align-items-center">
                                <i data-feather="corner-down-right" class="me-1" style="width:15px; height:15px;"></i>
                                Edit Customer
                            </button>
                        </div>

                </form>

                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-outline-danger border-0"
                        onclick="return confirm('Are you sure want to delete this Customer?')">
                        <i data-feather="trash-2"></i>
                    </button>
                </form>
            </div>
            </div>
        </div>
    </div>
    </div>
@endsection
