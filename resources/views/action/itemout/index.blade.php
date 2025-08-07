@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Outgoing Items</h5>
            <a href="{{ route('itemout.create') }}" class="btn btn-sm btn-primary d-flex align-items-center">
                <i data-feather="plus" class="me-1"></i> Input Outgoing Item
            </a>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('danger'))
            <div class="alert alert-danger mt-4">
                {{ session('danger') }}
            </div>
        @endif

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
                        @foreach ($outgoing as $item)
                            <tr class="text-center">
                                <td> <a href="{{ route('itemout.edit', $item->id) }}">{{ $item->code }}</a> </td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->note }}</td>
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
