@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fs-4">Items Category</h5>
            <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary d-flex align-items-center">
                <i data-feather="plus" class="me-1"></i> Create New Category
            </a>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success m-2" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('danger'))
            <div class="alert alert-danger m-2" role="alert">
                {{ session('danger') }}
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table id="categoryTable" class="table table-hover table-bordered table-sm align-middle w-auto mx-auto">
                    <thead>
                        <tr>
                            <th style="width: 1%;">No.</th>
                            <th>Category Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}"
                                        class="text-wrap text-decoration-none fs-6">
                                        {{ $category->name }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#categoryTable').DataTable({
                paging: true,
                searching: true,
                info: true,
                lengthChange: true,
                pageLength: 5,
            });
        });
    </script>
@endsection
