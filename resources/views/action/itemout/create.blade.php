@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add Outgoing Item Stock</h1>
        </div>

        <form action="{{ route('itemout.store') }}" method="POST" id="form-create">
            @csrf

            {{-- HEADER --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                name="code" placeholder="Input Code" value="{{ old('code') }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="note" class="form-label">Description</label>
                            <input type="text" class="form-control @error('note') is-invalid @enderror" id="note"
                                name="note" placeholder="Input Note" value="{{ old('note') }}">
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETAIL --}}
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
                                @php
                                    $oldItems = old('items', [['item_id' => '', 'quantity' => '', 'note' => '']]);
                                @endphp 

                                @foreach ($oldItems as $index => $oldItem)
                                    <tr data-index="{{ $index }}">
                                        <td>
                                            <input type="hidden" name="created_by" value="Admin">
                                            <select name="items[{{ $index }}][item_id]"
                                                class="form-control @error("items.$index.item_id") is-invalid @enderror"
                                                required>
                                                <option value="" hidden disabled
                                                    {{ $oldItem['item_id'] === '' ? 'selected' : '' }}>Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $oldItem['item_id'] == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("items.$index.item_id")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                class="form-control @error("items.$index.quantity") is-invalid @enderror"
                                                value="{{ $oldItem['quantity'] }}" required>
                                            @error("items.$index.quantity")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{ $index }}][note]"
                                                class="form-control @error("items.$index.note") is-invalid @enderror"
                                                value="{{ $oldItem['note'] }}">
                                            @error("items.$index.note")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger delete-row">
                                                <i data-feather="trash-2"></i>
                                            </button>
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

            {{-- TOMBOL --}}
            <div class="mt-4 d-flex gap-2 mb-4">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('itemout.index') }}" class="btn btn-secondary">Back To Index</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    let rowIndex = {{ count($oldItems) }};

    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('#detail-table tbody');

        // Fungsi untuk aktif/nonaktif tombol delete
        function toggleDeleteButtons() {
            const deleteButtons = tableBody.querySelectorAll('.delete-row');
            if (deleteButtons.length <= 1) {
                deleteButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.classList.add('disabled');
                    btn.setAttribute('title', 'Minimal 1 item harus ada');
                });
            } else {
                deleteButtons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('disabled');
                    btn.removeAttribute('title');
                });
            }
        }

        // Cek saat pertama kali load
        toggleDeleteButtons();

        // Tombol tambah baris
        document.getElementById('add-row').addEventListener('click', function() {
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-index', rowIndex);
            newRow.innerHTML = `
                <td>
                    <select name="items[${rowIndex}][item_id]" class="form-control" required>
                        <option value="" selected hidden disabled>Select Item</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control" required></td>
                <td><input type="text" name="items[${rowIndex}][note]" class="form-control"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger delete-row">
                        <i data-feather="trash-2"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(newRow);
            feather.replace();
            rowIndex++;
            toggleDeleteButtons();
        });

        // Tombol hapus baris
        tableBody.addEventListener('click', function(e) {
            if (e.target.closest('.delete-row')) {
                const row = e.target.closest('tr');
                row.remove();
                toggleDeleteButtons();
            }
        });
    });
</script>
@endsection

