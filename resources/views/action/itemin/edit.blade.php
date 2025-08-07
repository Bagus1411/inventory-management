@extends('layouts.main')

@section('content')
    <div class="container">
        {{-- Judul Halaman --}}
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Incoming Item Stock</h1>
        </div>

        {{-- 🔹 FORM HEADER --}}
        {{-- 🔹 FORM HEADER --}}
        <form id="form-detail" class="mt-4" action="{{ route('itemin.update', $incomingtransaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 d-flex">
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control  @error('code')is-invalid @enderror" id="code"
                                name="code" placeholder="Input Code"
                                value="{{ old('code', $incomingtransaction->code) }}">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control  @error('date')is-invalid @enderror" id="date"
                                name="date" placeholder="Select Date"
                                value="{{ old('date', $incomingtransaction->date) }}">
                            @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="note" class="form-label">Description</label>
                            <input type="text" class="form-control  @error('note')is-invalid @enderror" id="note"
                                name="note" placeholder="Input note"
                                value="{{ old('note', $incomingtransaction->note) }}">
                            @error('note')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>


            {{-- 🔹 FORM DETAIL --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Item Detail</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="detail-table">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $index => $detail)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="created_by" value="Admin">
                                            <select name="items[{{ $index }}][item_id]" class="form-control"
                                                required>
                                                <option disabled hidden>Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $detail->item_id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                class="form-control" value="{{ $detail->quantity }}" required>
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{ $index }}][note]"
                                                class="form-control" value="{{ $detail->note }}">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger delete-row"><i
                                                    data-feather="trash-2"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-row">
                            <i data-feather="plus"></i> Add Row
                        </button>
                    </div>
                </div>
            </div>
            {{-- Redesain tombol aksi --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                {{-- Tombol kiri: Edit dan Back --}}
                <div class="btn-group btn-group-sm">
                    <button type="submit" class="btn btn-outline-primary" form="form-detail">
                        <i data-feather="edit-3" class="me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('itemin.index') }}" class="btn btn-outline-secondary">
                        <i data-feather="arrow-left" class="me-1"></i> Back
                    </a>
                </div>

                {{-- Tombol kanan: Delete --}}
                <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i data-feather="trash-2"></i> Delete
                </button>
            </div>

        </form>

        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Alert</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        YOU SURE NAK DELETE NI BANG??
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('itemin.destroy', $incomingtransaction->id) }}" method="POST"
                            class="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">DELETE LA BANGGGGGGGG!!!!!!!!!!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        let rowIndex = {{ count($details) }};

        document.addEventListener('DOMContentLoaded', function() {
            // Tombol tambah baris
            document.getElementById('add-row').addEventListener('click', function() {
                const tbody = document.querySelector('#detail-table tbody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
        <td>
            <input type="hidden" name="created_by" value="Admin">
            <select name="items[${rowIndex}][item_id]" class="form-control" required>
                <option hidden disabled selected>Select Item</option>
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="items[${rowIndex}][quantity]" class="form-control" placeholder="Input Quantity" required>
        </td>
        <td>
            <input type="text" name="items[${rowIndex}][note]" class="form-control" placeholder="Input Notes">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger delete-row"><i data-feather="trash-2"></i></button>
        </td>
    `;
                tbody.appendChild(newRow);
                feather.replace();
                rowIndex++;
            });


            // Tombol hapus baris
            document.querySelector('#detail-table').addEventListener('click', function(e) {
                if (e.target.closest('.delete-row')) {
                    const row = e.target.closest('tr');
                    row.remove();
                }
            });
        });
    </script>
@endsection
