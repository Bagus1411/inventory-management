@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add Incoming Item Stock</h1>
        </div>

        {{-- 🔹 FORM HEADER & DETAIL --}}
        <form action="{{ route('itemin.store') }}" method="POST" id="form-create">
            @csrf

            {{-- Header --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Input Code" required>
                        </div>
                        <div class="col-md-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-4">
                            <label for="note" class="form-label">Description</label>
                            <input type="text" class="form-control" id="note" name="note"
                                placeholder="Input Note">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail --}}
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
                                <tr data-index="0">
                                    <td>
                                        <input type="hidden" name="created_by" value="Admin">
                                        <select name="items[0][item_id]" class="form-control" required>
                                            <option value="" selected hidden disabled>Select Item</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
                                    <td><input type="text" name="items[0][note]" class="form-control"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger delete-row">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-row">
                            <i data-feather="plus"></i> Add Row
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="mt-4 d-flex gap-2 mb-4">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('itemin.index') }}" class="btn btn-secondary">Back To Index</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        let rowIndex = 1;
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })

        document.addEventListener('DOMContentLoaded', function() {



            document.getElementById('add-row').addEventListener('click', function() {
                const tbody = document.querySelector('#detail-table tbody');
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
                tbody.appendChild(newRow);
                feather.replace();
                rowIndex++;
            });


            // Delete row
            document.querySelector('#detail-table').addEventListener('click', function(e) {
                if (e.target.closest('.delete-row')) {
                    const row = e.target.closest('tr');
                    row.remove();
                }
            });
        });
    </script>
@endsection
