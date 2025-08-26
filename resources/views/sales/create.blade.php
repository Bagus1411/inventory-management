@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add Sales Invoice</h1>
        </div>





        {{-- 🔹 FORM HEADER & DETAIL --}}
        <form action="{{ route('sales.store') }}" method="POST" id="form-create">
            @csrf

            {{-- 🔴 ERROR MESSAGE GLOBAL --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Header --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">General Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="number" class="form-label">Invoice Number<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"
                                name="number" placeholder="INV-001" value="{{ old('number') }}">
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="customer" class="form-label">Customer<span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer"
                                class="form-control @error('customer_id') is-invalid @enderror">
                                <option selected hidden disabled>Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="date" class="form-label">Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" placeholder="Invoice description"
                                value="{{ old('description') }}">
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Invoice Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="detail-table">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width: 13%">Item<span class="text-danger">*</span></th>
                                    <th style="width: 9%">Quantity<span class="text-danger">*</span></th>
                                    <th style="width: 13%">Price<span class="text-danger">*</span></th>
                                    <th style="width: 10%">Disc (%)<span class="text-danger">*</span></th>
                                    <th style="width: 15%">Disc (Rp)</th>
                                    <th style="width: 15%">Note</th>
                                    <th style="width: 15%">Subtotal</th>
                                    <th style="width: 5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty(old('items')))
                                    @foreach (old('items') as $index => $value)
                                        <tr data-index="{{ $index }}">
                                            <td>
                                                <select name="items[{{ $index }}][item_id]"
                                                    class="form-control 
                                                    @error('items.' . $index . '.item_id') is-invalid @enderror">
                                                    <option selected hidden disabled>Select Item</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}" @selected(old('items.' . $index . '.item_id') == $item->id)>
                                                            {{ $item->name }} (Stok:{{ $item->stock }})</option>
                                                    @endforeach
                                                </select>
                                                @error('items.' . $index . '.item_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    placeholder="Qty" value="1"
                                                    class="form-control @error('items.' . $index . '.quantity') is-invalid @enderror">
                                                @error('items.' . $index . '.quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][price]"
                                                    placeholder="Price"
                                                    class="form-control @error('items.' . $index . '.price') is-invalid @enderror"
                                                    step="1000">
                                                @error('items.' . $index . '.price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][discount_percent]" placeholder="%"
                                                    class="form-control @error('items.' . $index . '.discount_percent') @enderror"
                                                    value="{{ old('items[0][discount_percent]', '0') }}" step="1">
                                                @error('items.' . $index . '.discount_percent')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" readonly name="items[0][discount_amount]"
                                                    placeholder="Rp" class="form-control bg-gray-400 text-muted" step="0.01">
                                            </td>
                                            <td>
                                                <input type="text" name="items[0][note]" placeholder="Note"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" readonly name="items[0][subtotal]"
                                                    placeholder="Subtotal" class="form-control" step="0.01">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger delete-row">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr data-index="0">
                                        <td>
                                            <select name="items[0][item_id]"
                                                class="form-control 
                                            @error('items[0][item_id]') is-invalid @enderror">
                                                <option selected hidden disabled>Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}" @selected(old('items[0][item_id]') == $item->id)>
                                                        {{ $item->name }} (Stok:
                                                        {{ $item->stock }})</option>
                                                @endforeach
                                            </select>
                                            @error('items[0][item_id]')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][quantity]" placeholder="Qty"
                                                value="1"
                                                class="form-control @error('items[0][quantity]') is-invalid @enderror">
                                            @error('items[0][quantity]')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][price]" placeholder="Price"
                                                class="form-control @error('items[0][price]') is-invalid @enderror"
                                                step="0.01">
                                            @error('items[0][price]')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][discount_percent]" placeholder="%"
                                                class="form-control @error('items[0][discount_percent]') is-invalid @enderror" 
                                                value="0" step="1">
                                            @error('items[0][discount_percent]')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input  type="number" readonly name="items[0][discount_amount]"
                                                style="background-color: #E9ECEF"
                                                placeholder="Rp" class="form-control " step="0.01">
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][note]" placeholder="Note"
                                                class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" readonly name="items[0][subtotal]"
                                                style="background-color: #E9ECEF"
                                                placeholder="Subtotal" class="form-control" step="0.01">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger delete-row">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                                <tr class="total-row">
                                    <td colspan="6" class="text-end fw-bold">
                                        Total
                                    </td>
                                    <td>
                                        <input type="number" readonly name="total" id=""
                                            style="background-color: #E9ECEF" class="form-control" step="0.01">
                                    </td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-row">
                            <i data-feather="plus"></i> Add Row
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer Fields --}}
            <div class="row mt-2 g-3">
                <div class="col-lg-6">
                    <div class="card shadow-sm px-3">
                        <div class="card-body">
                            <div class="mb-3  ">
                                <label for="discount_global" class="form-label">Global Discount</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="input-group">
                                        <div class="input-group-text">%</div>
                                        <input type="number" class="form-control" name="discount_global"
                                            id="discount_global" value="{{ old('discount_global', '0') }}">
                                    </div>
                                    <i data-feather="minus"></i>
                                    <div class="input-group">
                                        <div class="input-group-text">Rp.</div>
                                        <input type="number" readonly class="form-control" name="discount_global2"
                                            style="background-color: #E9ECEF"
                                            id="discount_global2" value="{{ old('discount_global2') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="ppn" class="form-label">PPn (%)</label>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="input-group">
                                        <div class="input-group-text">%</div>
                                        <input type="number" class="form-control" name="ppn" id="ppn"
                                            step="1" value="{{ old('ppn', '0') }}">
                                    </div>

                                    <i data-feather="minus"></i>

                                    <div class="input-group">
                                        <div class="input-group-text">Rp.</div>
                                        <input type="number" readonly class="form-control" name="ppn2"
                                            style="background-color: #E9ECEF"
                                            id="ppn2" step="1" value="{{ old('ppn2') }}">
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
                                <label for="total_item_value" class="form-label">Total Items Value</label>
                                <div class="input-group">
                                    <div class="input-group-text">Rp.</div>
                                    <input type="number" readonly class="form-control" name="total_item_value"
                                        style="background-color: #E9ECEF"
                                        id="total_item_value" value="{{ old('total_item_value') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="t_a_g_d" class="form-label">Total After Global Discount</label>
                                <div class="input-group">
                                    <div class="input-group-text">Rp.</div>
                                    <input type="number" readonly class="form-control" name="t_a_g_d" id="t_a_g_d"
                                        style="background-color: #E9ECEF"
                                        step="0.01" value="{{ old('t_a_g_d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card shadow-sm mt-4">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div class="col-lg-6 text-center">
                        <label for="grand_total" class="form-label  fw-bold">Grand Total</label>
                        <div class="input-group">
                            <div class="input-group-text">Rp.</div>
                            <input type="number" readonly class="form-control" name="grand_total" id="grand_total"
                                style="background-color: #E9ECEF"
                                step="0.01" value="{{ old('grand_total') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="mt-4 d-flex gap-2 mb-4">
                <button type="submit" class="btn btn-outline-primary d-inline-flex align-items-center">
                    <i data-feather="save" class="me-1" style="width:15px; height:15px;"></i> 
                    Create
                </button>
                <a href="{{ route('sales.index') }}" class="btn btn-outline-danger d-inline-flex align-items-center">
                   <i data-feather="chevrons-left" class="me-1" style="width:15px; height:15px;"></i> Cancel
                </a>
            </div>
        </form>
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
                const discountGlobalValue = totalItemValue * (discountGlobalPercent / 100);
                document.getElementById('discount_global2').value = discountGlobalValue.toFixed(2);

                // Total setelah diskon global
                const afterGlobalDiscount = totalItemValue - discountGlobalValue;
                document.getElementById('t_a_g_d').value = afterGlobalDiscount.toFixed(2);

                // PPN
                const ppnPercent = parseFloat(document.getElementById('ppn').value) || 0;
                const ppnValue = afterGlobalDiscount * (ppnPercent / 100);
                document.getElementById('ppn2').value = ppnValue.toFixed(2);

                // Grand total
                const grandTotal = totalWithDiscount - discountGlobalValue + ppnValue;
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
                <td><input type="number" name="items[${rowIndex}][quantity]" placeholder="Qty" value="1" class="form-control" required></td>
                <td><input type="number" name="items[${rowIndex}][price]" placeholder="Price" class="form-control" step="0.01" required></td>
                <td><input type="number" name="items[${rowIndex}][discount_percent]" placeholder="%" class="form-control" step="0.01"></td>
                <td><input type="number" readonly name="items[${rowIndex}][discount_amount]" placeholder="0,00" class="form-control" step="0.01"></td>
                <td><input type="text" name="items[${rowIndex}][note]" placeholder="Note" class="form-control"></td>
                <td><input type="number" readonly name="items[${rowIndex}][subtotal]" placeholder="0,00" class="form-control" step="0.01"></td>
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
