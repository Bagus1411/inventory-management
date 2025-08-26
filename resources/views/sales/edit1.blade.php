@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Sales Invoice</h1>
        </div>

        {{-- 🔹 FORM HEADER & DETAIL --}}
        <form action="{{ route('sales.update', $sales->id) }}" method="POST" id="form-create">
            @csrf
            @method('PUT')

            {{-- Header --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="number" class="form-label">Invoice Number</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" placeholder="INV-001" value="{{ old('number', $sales->number) }}" required>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select name="customer_id" id="customer_id"
                                class="form-control @error('customer_id') is-invalid @enderror" required>
                                <option selected hidden disabled>Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id', $sales->customer_id) == $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date', $sales->date) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" placeholder="Invoice description"
                                value="{{ old('description', $sales->description) }}">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Invoice Details --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Invoice Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="detail-table">
                            <thead class="table-light text-center">
                                <tr class="table-light">
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Discount (%)</th>
                                    <th>Discount (Rp)</th>
                                    <th>Note</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- 🔹 Isi item dari old() atau dari $details --}}
                                @if (!empty(old('items')))
                                    @foreach (old('items') as $index => $value)
                                        <tr>
                                            <td>
                                                <select name="items[{{ $index }}][item_id]" class="form-select">
                                                    <option value="">-- Select Item --</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $value['item_id'] ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    value="{{ $value['quantity'] }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][descripti?on]"
                                                    value="{{ $value['description'] }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][unit]"
                                                    value="{{ $value['unit'] }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][price]"
                                                    value="{{ $value['price'] }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][discount]"
                                                    value="{{ $value['discount'] }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" disabled class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger delete-row">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach ($details as $index => $value)
                                        <tr>
                                            <td >
                                                <select name="items[{{ $index }}][item_id]" class="form-select">
                                                    <option value="">-- Select Item --</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $value->item_id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    value="{{ $value->quantity }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][price]"
                                                    value="{{ $value->price }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="items[{{ $index }}][discount_percent]"
                                                    value="{{ $value->discount_percent }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" disabled name="items[0][discount_amount]"
                                                    placeholder="Rp" value="{{ old("items.$index.discount_amount") }}"
                                                    class="form-control" step="0.01">
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][note]"
                                                    value="{{ $value->note }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" disabled name="items[0][subtotal]"
                                                    placeholder="Subtotal"
                                                    value="{{ old('items' . $index . 'subtotal') }}" class="form-control"
                                                    step="0.01">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger delete-row">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                {{-- 🔹 Row Total --}}
                                <tr class="total-row">
                                    <td colspan="6" class="text-end fw-bold">Total</td>
                                    <td><input type="number" disabled name="items_total" class="form-control"></td>
                                    <td></td>
                                </tr>

                                {{-- 🔹 Footer Fields (dimasukkan ke dalam tbody juga) --}}
                                <tr>
                                    <td>
                                        <div class="row mt-2 g-3">
                                            <div class="col-lg-6">
                                                <div class="card shadow-sm px-3">
                                                    <div class="card-body">
                                                        <div class="mb-3  ">
                                                            <label for="discount_global" class="form-label">Global
                                                                Discount</label>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="input-group">
                                                                    <div class="input-group-text">%</div>
                                                                    <input type="number" class="form-control"
                                                                        name="discount_global" id="discount_global"
                                                                        value="{{ old('discount_global') }}">
                                                                </div>
                                                                <i data-feather="minus"></i>
                                                                <div class="input-group">
                                                                    <div class="input-group-text">Rp.</div>
                                                                    <input type="number" disabled class="form-control"
                                                                        name="discount_global2" id="discount_global2"
                                                                        value="{{ old('discount_global2') }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="ppn" class="form-label">PPn (%)</label>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <div class="input-group">
                                                                    <div class="input-group-text">%</div>
                                                                    <input type="number" class="form-control"
                                                                        name="ppn" id="ppn" step="0.01"
                                                                        value="{{ old('ppn') }}">
                                                                </div>

                                                                <i data-feather="minus"></i>

                                                                <div class="input-group">
                                                                    <div class="input-group-text">Rp.</div>
                                                                    <input type="number" disabled class="form-control"
                                                                        name="ppn2" id="ppn2" step="0.01"
                                                                        value="{{ old('ppn2') }}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="card shadow-sm px-3">
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="total_item_value" class="form-label">Total Items
                                                                Value</label>
                                                            <div class="input-group">
                                                                <div class="input-group-text">Rp.</div>
                                                                <input type="number" disabled class="form-control"
                                                                    name="total_item_value" id="total_item_value"
                                                                    value="{{ old('total_item_value') }}">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="t_a_g_d" class="form-label">Total After Global
                                                                Discount</label>
                                                            <div class="input-group">
                                                                <div class="input-group-text">Rp.</div>
                                                                <input type="number" disabled class="form-control"
                                                                    name="t_a_g_d" id="t_a_g_d" step="0.01"
                                                                    value="{{ old('t_a_g_d') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    </div>
                    </td>
                    <td>
                        <div class="card shadow-sm mt-4">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class="col-lg-6 text-center">
                                    <label for="grand_total" class="form-label  fw-bold">Grand Total</label>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp.</div>
                                        <input type="number" readonly class="form-control" name="grand_total"
                                            id="grand_total" step="0.01" value="{{ old('grand_total') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    </tr>

                    </tbody>
                    </table>

                    <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-row">
                        <i data-feather="plus"></i> Add Row
                    </button>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                {{-- Tombol kiri: Edit dan Back --}}
                <div class="btn-group btn-group-sm">
                    <button type="submit" class="btn btn-outline-primary" form="form-detail">
                        <i data-feather="edit-3" class="me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
                        <form action="{{ route('sales.destroy', $sales->id) }}" method="POST" class="">
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
        let rowIndex = 1;

        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.querySelector('#detail-table tbody');

            // 🔹 Toggle tombol delete (enable/disable)
            function toggleDeleteButtons() {
                const rows = tbody.querySelectorAll('tr:not(.total-row)');
                const deleteButtons = tbody.querySelectorAll('.delete-row');

                if (rows.length === 1) {
                    deleteButtons.forEach(btn => {
                        btn.disabled = true;
                        btn.classList.add('disabled-btn');
                    });
                } else {
                    deleteButtons.forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('disabled-btn');
                    });
                }
            }

            // 🔹 Hitung ulang semua subtotal + total
            function calculateAll() {
                let totalItemValue = 0; // harga murni tanpa diskon
                let totalWithDiscount = 0; // total sudah diskon (untuk row total di tabel)

                tbody.querySelectorAll('tr[data-index]').forEach(row => {
                    const qty = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
                    const price = parseFloat(row.querySelector('input[name*="[price]"]').value) || 0;
                    const discPercent = parseFloat(row.querySelector('input[name*="[discount_percent]"]')
                        .value) || 0;

                    const rowTotal = price * qty; // harga murni tanpa diskon
                    const discAmount = rowTotal * (discPercent / 100);
                    const subtotal = rowTotal - discAmount;

                    row.querySelector('input[name*="[discount_amount]"]').value = discAmount.toFixed(2);
                    row.querySelector('input[name*="[subtotal]"]').value = subtotal.toFixed(2);

                    // 🔹 Tambahkan ke masing-masing total
                    totalItemValue += rowTotal; // tanpa diskon
                    totalWithDiscount += subtotal; // sudah diskon
                });

                // 🔹 Total item value (murni, tanpa diskon)
                document.getElementById('total_item_value').value = totalItemValue.toFixed(2);

                // Diskon global
                const discountGlobalPercent = parseFloat(document.getElementById('discount_global').value) || 0;
                const discountGlobalValue = totalWithDiscount * (discountGlobalPercent / 100);
                document.getElementById('discount_global2').value = discountGlobalValue.toFixed(2);

                // Total setelah diskon global
                const afterGlobalDiscount = totalWithDiscount - discountGlobalValue;
                document.getElementById('t_a_g_d').value = afterGlobalDiscount.toFixed(2);

                // PPN
                const ppnPercent = parseFloat(document.getElementById('ppn').value) || 0;
                const ppnValue = afterGlobalDiscount * (ppnPercent / 100);
                document.getElementById('ppn2').value = ppnValue.toFixed(2);

                // Grand total
                const grandTotal = afterGlobalDiscount + ppnValue;
                document.getElementById('grand_total').value = grandTotal.toFixed(2);

                // 🔹 Update total di row tabel (pakai subtotal, sudah diskon)
                const totalInput = tbody.querySelector('tr.total-row input');
                if (totalInput) {
                    totalInput.value = totalWithDiscount.toFixed(2);
                }
            }

            // 🔹 Listener untuk input quantity, price, discount
            document.querySelector('#detail-table').addEventListener('input', function(e) {
                if (e.target.matches(
                        'input[name*="[quantity]"], input[name*="[price]"], input[name*="[discount_percent]"]'
                    )) {
                    calculateAll();
                }
            });

            // 🔹 Listener untuk global discount & ppn
            document.getElementById('discount_global').addEventListener('input', calculateAll);
            document.getElementById('ppn').addEventListener('input', calculateAll);

            // 🔹 Add Row
            document.getElementById('add-row').addEventListener('click', function() {
                const totalRow = tbody.querySelector('tr.total-row');

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
                <td><input type="number" name="items[${rowIndex}][quantity]" placeholder="Qty" class="form-control" required></td>
                <td><input type="number" name="items[${rowIndex}][price]" placeholder="Price" class="form-control" step="0.01" required></td>
                <td><input type="number" name="items[${rowIndex}][discount_percent]" placeholder="%" class="form-control" step="0.01"></td>
                <td><input type="number" disabled name="items[${rowIndex}][discount_amount]" placeholder="0,00" class="form-control" step="0.01"></td>
                <td><input type="text" name="items[${rowIndex}][note]" placeholder="Note" class="form-control"></td>
                <td><input type="number" disabled name="items[${rowIndex}][subtotal]" placeholder="0,00" class="form-control" step="0.01"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger delete-row">
                        <i data-feather="trash-2"></i>
                    </button>
                </td>
            `;

                tbody.insertBefore(newRow, totalRow);
                feather.replace();
                rowIndex++;

                toggleDeleteButtons();
            });

            // 🔹 Delete Row
            document.querySelector('#detail-table').addEventListener('click', function(e) {
                if (e.target.closest('.delete-row')) {
                    const btn = e.target.closest('.delete-row');
                    if (!btn.disabled) {
                        btn.closest('tr').remove();
                        toggleDeleteButtons();
                        calculateAll();
                    }
                }
            });

            // 🔹 Inisialisasi awal
            toggleDeleteButtons();
            calculateAll();
        });
    </script>
@endsection
