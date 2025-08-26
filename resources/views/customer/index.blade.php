@extends('layouts.main')

@section('content')
    <div class="card mt-4 shadow-sm col-lg-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fs-4">Customers</h5>
            <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary d-flex align-items-center">
                <i data-feather="user-plus" class="me-1"></i> Create New Customer
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
                <table id="categoryTable" class="table table-hover table-bordered table-sm align-middle w-auto mx-auto py-3">
                    <thead>
                        <tr>
                            <th style="width: 1%;">No.</th>
                            <th>Code</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                        class="text-wrap text-decoration-none fs-6">
                                        {{ $customer->code }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('customer.edit', $customer->id) }}"
                                        class="text-wrap text-decoration-none fs-6 text-dark">
                                        {{ $customer->name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div
                                        class="text-wrap text-decoration-none fs-6 text-dark">
                                        {{ $customer->status }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger border-0 btn-delete" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop" data-id="{{ $customer->id }}"
                                        data-name="{{ $customer->name }}" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        
                                        <i data-feather="user-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">NAK DELETE NI
                        BANG??</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    YOU SURE KE BANG???
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary border-0" data-bs-dismiss="modal">Tak Sure
                        La</button>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger border-0">SURE
                            LA BROO NAK DELETE NI AA!!!!!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // const myModal = document.getElementById('myModal')
        // const myInput = document.getElementById('myInput')

        // myModal.addEventListener('shown.bs.modal', () => {
        //     myInput.focus()
        // })

        $(document).ready(function() {
            // Saat tombol delete ditekan
            $(document).on('click', '.btn-delete', function() {
                let userId = $(this).data('id');
                let url = "{{ route('customer.destroy', ':id') }}";
                url = url.replace(':id', userId);
                $('#deleteForm').attr('action', url);
            });
        });

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
