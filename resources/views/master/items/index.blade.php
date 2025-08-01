@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fs-4">Items</h5>
            <a href="{{ route('items.create') }}" class="btn btn-primary d-flex align-items-center">
                <i data-feather="plus" class="me-1"></i> Create New Item
            </a>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success col-lg-6 m-2" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('danger'))
            <div class="alert alert-danger col-lg-6 m-2" role="alert">
                {{ session('danger') }}
            </div>
        @endif


        <div class="card-body">
            <div class="table-responsive">
                <table id="itemsTable" class="table table-hover table-bordered table-sm align-middle py-3">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Category</th>
                            <th scope="col">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('items.edit', $item->id) }}" class="text-decoration-none">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('items.edit', $item->id) }}" class="text-decoration-none text-black">
                                        {{ $item->description }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('items.edit', $item->id) }}" class="text-decoration-none text-black">
                                        {{ $item->category->name }}
                                    </a>
                                </td>
                                <td>{{ $item->stock }}</td>
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
            $('#itemsTable').DataTable({
                paging: true,
                searching: true,
                info: true,
                lengthChange: true,
            });
        });
    </script>
@endsection
