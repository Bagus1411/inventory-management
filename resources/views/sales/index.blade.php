@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fs-4">Sales</h5>
            <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary d-flex align-items-center">
                <i data-feather="circle-plus" class="me-1"></i> Create New Sales
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
                <table class="table table-hover table-bordered table-sm align-middle py-3" id="example">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th scope="col">number</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                            <th scope="col">Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr class="text-center">
                                <td> <a href="{{ route('sales.edit', ['sale' => $sale->id]) }}">{{ $sale->number }}</a> </td>
                                <td>{{ $sale->customer->name }}</td>
                                <td>{{ $sale->date }}</td>
                                <td>{{ $sale->description }}</td>
                                <td>{{ number_format($sale->grand_total, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    paging: true, // ⬅️ fitur pagination
                    pageLength: 5, // jumlah data per halaman
                    lengthChange: true, // pengguna bisa ubah jumlah baris/halaman
                    searching: true,
                    ordering: true,
                    info: true
                });
            });
        </script>
    @endsection
</div>
@endsection
