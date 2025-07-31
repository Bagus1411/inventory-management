@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Incoming Items</h5>
            <a href="{{ route('itemin.create') }}" class="btn btn-sm btn-primary d-flex align-items-center">
                <i data-feather="plus" class="me-1"></i> Input Incoming Item
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm align-middle py-3" id="example">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 10; $i++)
                            <tr class="text-center">
                                <td> <a class="text-decoration-none" href="{{ route('itemin.edit', ['itemin' => $i]) }}">
                                        ITM{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                                    </a></td>
                                <td>{{ rand(1, 100) }}</td>
                                <td>Description example {{ $i }}</td>
                            </tr>
                        @endfor
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
