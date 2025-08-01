@extends('layouts.main')

@section('content')
    <div class="container">
        {{-- Judul Halaman --}}
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add Item Stock</h1>
        </div>

        {{-- 🔹 FORM HEADER --}}
        {{-- 🔹 FORM HEADER --}}
        <form id="form-header" class="mb-4">
            @csrf
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="kode" class="form-label">Code</label>
                            <input type="text" class="form-control" id="kode" name="kode"
                                placeholder="Input Code">
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal" class="form-label">Date</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                placeholder="Select Date">
                        </div>
                        <div class="col-md-4">
                            <label for="keterangan" class="form-label">Description</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Input Description">
                        </div>
                    </div>
                </div>
            </div>
        </form>


        {{-- 🔹 FORM DETAIL --}}
        <form id="form-detail">
            @csrf
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
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="" id="" class="form-control">
                                            <option value="" selected hidden disabled>Select Item</option>
                                            <option value="ijanwd">anjay</option>
                                            <option value="kwjev">awd</option>
                                            <option value="awdawd">anawdawdjay</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="" id="" class="form-control">
                                            <option value="" selected hidden disabled>Select Category</option>
                                            <option value="ijanwd">anjay</option>
                                            <option value="kwjev">awd</option>
                                            <option value="awdawd">anawdawdjay</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="kuantitas[]" class="form-control" required
                                            placeholder="Input Quantity"></td>
                                    <td><input type="text" name="catatan[]" class="form-control" required
                                            placeholder="Input Notes"></td>
                                    <td>
                                        <select name="" id="" class="form-control">
                                            <option value="" selected hidden disabled>Select Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="paid">Paid</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </td>
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
            <div class="mt-4 d-flex gap-2 mb-4">
                <button type="submit" class="btn btn-primary" form="form-detail">Create</button>
                <button type="button" class="btn btn-danger">Delete</button>
                <a href="{{ route('itemin.index') }}" class="btn btn-secondary">Back To Index</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tombol tambah baris
            document.getElementById('add-row').addEventListener('click', function() {
                const tbody = document.querySelector('#detail-table tbody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <select name="" id="" class="form-control">
                                <option value="" selected hidden disabled>Select Item</option>
                                <option value="ijanwd">anjay</option>
                                <option value="kwjev">awd</option>
                                <option value="awdawd">anawdawdjay</option>
                        </select>
                    </td>
                    <td>
                        <select name="" id="" class="form-control">
                                <option value="" selected hidden disabled>Select Category</option>
                                <option value="ijanwd">anjay</option>
                                <option value="kwjev">awd</option>
                                <option value="awdawd">anawdawdjay</option>
                        </select>
                    </td>
                    <td><input type="number" name="kuantitas[]" class="form-control" required placeholder="Input Quantity"></td>
                    <td><input type="text" name="catatan[]" class="form-control" required placeholder="Input Notes"></td>
                    <td>
                        <select name="" id="" class="form-control">
                            <option value="" selected hidden disabled>Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger delete-row">
                            <i data-feather="trash-2"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(newRow);
                feather.replace(); // refresh feather icon
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
