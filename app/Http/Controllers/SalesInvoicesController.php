<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\SalesInvoices;
use App\Models\SalesInvoiceDetail;
use App\Http\Requests\SalesInvoicesRequest;

class SalesInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sales.index', [
            'title' => 'Sales',
            'sales' => SalesInvoices::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SalesInvoices $sale)
    {
        return view('sales.create', [
            'title' => 'Sales',
            'details' => $sale->details,
            'sales' => SalesInvoices::all(),
            'customers' => Customer::all(),
            'items' => Item::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesInvoicesRequest $request)
    {


        $validatedData = $request->validated();

        // dd($validatedData);

        $discountGlobal = isset($validatedData['discount_global']) ? (float) $validatedData['discount_global'] : 0.0;
        $ppn = isset($validatedData['ppn']) ? (float) $validatedData['ppn'] : 0.0;



        // 🔒 VALIDASI: cek semua stok sebelum simpan
        foreach ($validatedData['items'] as $detail) {
            $item = Item::find($detail['item_id']);
            if ($item && $item->stock < $detail['quantity']) {
                return back()->withErrors([
                    'items' => "Stok '{$item->name}' hanya tersedia {$item->stock}, 
                           tidak cukup untuk dikurangi {$detail['quantity']}."
                ])->withInput();
            }
        }

        // Simpan transaksi utama
        $transaction = SalesInvoices::create([
            'number' => $validatedData['number'],
            'customer_id' => $validatedData['customer_id'] ?? null,
            'description' => $validatedData['description'] ?? null,
            'date' => $validatedData['date'],
            'discount_global' => $discountGlobal,
            'ppn' => $ppn,
            'grand_total' => $validatedData['grand_total'],
            'total' => $validatedData['total']
        ]);

        foreach ($validatedData['items'] as $detail) {
            $discountPercent = isset($detail['discount_percent']) ? (float) $detail['discount_percent'] : 0.0;
            // Simpan detail
            SalesInvoiceDetail::create([
                'sales_invoice_id' => $transaction->id,
                'item_id' => $detail['item_id'],
                'quantity' => $detail['quantity'],
                'note' => $detail['note'] ?? null,
                'price' => $detail['price'],
                'discount_percent' => $discountPercent,
                'discount_rp' => $detail['discount_amount'] ?? 0,
                'subtotal' => $detail['subtotal'] ?? 0
            ]);


            // Update stok
            if ($item = Item::find($detail['item_id'])) {
                $item->stock = (int) $item->stock - (int) $detail['quantity'];
                $item->save();
            }
        }

        return redirect()->route('sales.index')->with('success', 'Transaksi keluar berhasil disimpan dan stok diperbarui!');

    }

    /**
     * Display the specified resource.
     */
    public function show(SalesInvoices $salesInvoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesInvoices $sale)
    {
        return view('sales.edit', [
            'title' => 'Edit Sales',
            'sales' => $sale,
            'details' => $sale->details,
            'customers' => Customer::all(),
            'items' => Item::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesInvoicesRequest $request, SalesInvoices $sale)
    {
        $validated = $request->validated();
        $discountGlobal = isset($validated['discount_global']) ? (float) $validated['discount_global'] : 0.0;
        $ppn = isset($validated['ppn']) ? (float) $validated['ppn'] : 0.0;


        // 🔒 VALIDASI: cek semua stok sebelum simpan
        foreach ($validated['items'] as $detail) {
            $item = Item::find($detail['item_id']);
            if ($item && $item->stock < $detail['quantity']) {
                return back()->withErrors([
                    'items' => "Stok '{$item->name}' hanya tersedia {$item->stock}, 
                           tidak cukup untuk dikurangi {$detail['quantity']}."
                ])->withInput();
            }
        }


        // 🔁 STEP 1: Kembalikan stok lama (ROLLBACK)
        foreach ($sale->details as $oldDetail) {
            $item = Item::find($oldDetail->item_id);
            if ($item) {
                $item->stock += $oldDetail->quantity;
                $item->save();
            }
        }

        // 🔒 STEP 2: Validasi stok cukup untuk data baru
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $detail) {
                $item = Item::find($detail['item_id']);
                if ($item && $item->stock < $detail['quantity']) {
                    return back()->withErrors([
                        'items' => "Stok barang '{$item->name}' hanya tersedia {$item->stock}, tidak cukup untuk dikurangi {$detail['quantity']}.",
                    ])->withInput();
                }
            }
        }

        // 🗑️ STEP 3: Hapus semua detail lama
        $sale->details()->delete();

        // ✏️ STEP 4: Update data utama transaksi
        $sale->update([
            'number' => $validated['number'],
            'customer_id' => $validated['customer_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'date' => $validated['date'],
            'discount_global' => $discountGlobal,
            'ppn' => $ppn,
            'grand_total' => $validated['grand_total'],
            'total' => $validated['total']
        ]);

        // ➕ STEP 5: Tambahkan detail baru dan update stok
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $detail) {
                $discountPercent = isset($detail['discount_percent']) ? (float) $detail['discount_percent'] : 0.0;
                // Simpan detail transaksi
                SalesInvoiceDetail::create([
                    'sales_invoice_id' => $sale->id,
                    'item_id' => $detail['item_id'],
                    // 'category_id' => $detail['category_id'],
                    'quantity' => $detail['quantity'],
                    'note' => $detail['note'] ?? null,
                    'price' => $detail['price'],
                    'discount_percent' => $discountPercent,
                    'discount_rp' => $detail['discount_amount'] ?? 0,
                    'subtotal' => $detail['subtotal'] ?? 0
                ]);

                // Kurangi stok sesuai quantity baru
                $item = Item::find($detail['item_id']);
                if ($item) {
                    $item->stock -= $detail['quantity'];
                    $item->save();
                }
            }
        }

        // ✅ SELESAI
        return redirect()->route('sales.index')->with('success', 'Transaksi berhasil diperbarui dan stok disesuaikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesInvoices $sale)
    {
        // 🔁 STEP 1: Kembalikan stok ke semula (kurangi stok yang pernah ditambahkan)
        foreach ($sale->details as $detail) {
            $item = Item::find($detail->item_id);
            if ($item) {
                $item->stock = max(0, $item->stock + $detail->quantity); // Hindari nilai minus
                $item->save();
            }
        }

        // 🗑️ STEP 2: Hapus semua detail transaksi
        $sale->details()->delete();

        // 🗑️ STEP 3: Hapus transaksi utama
        $sale->delete();

        // ✅ STEP 4: Redirect kembali dengan pesan sukses
        return redirect()->route('sales.index')->with('danger', 'Data transaksi berhasil dihapus dan stok telah disesuaikan.');
    }
}
