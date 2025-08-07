<?php

namespace App\Http\Controllers;

use App\Models\OutgoingTransaction;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\OutgoingTransDetail;
class OutgoingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('action.itemout.index', [
            'title' => 'Outgoing Transaction',
            'outgoing' => OutgoingTransaction::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('action.itemout.create', [
            'title' => 'Outgoing Transaction',
            'Category' => Category::all(),
            'items' => Item::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input utama
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:outgoing_transaction,code',
            'note' => 'nullable|string|max:255',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'created_by' => 'required|string|max:255',
            'items.*.item_id' => 'required|exists:items,id',
            // 'items.*.category_id' => 'required|exists:categories,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.note' => 'nullable|string|max:255',
        ]);

        // return $validated;

        // Simpan transaksi utama
        $transaction = OutgoingTransaction::create([
            'code' => $validated['code'],
            'note' => $validated['note'] ?? null,
            'date' => $validated['date'],
            'created_by' => auth()->user()->name ?? 'Admin',
        ]);

        // Simpan detail & update stok
        foreach ($validated['items'] as $detail) {
            // Simpan detail
            OutgoingTransDetail::create([
                'outgoing_transaction_id' => $transaction->id,
                'item_id' => $detail['item_id'],
                // 'category_id' => $detail['category_id'],
                'quantity' => $detail['quantity'],
                'note' => $detail['note'] ?? null,
            ]);

            // Update stok
            $item = Item::find($detail['item_id']);
            if ($item) {
                $item->stock -= $detail['quantity'];
                $item->save();
            }
        }

        return redirect()->route('itemout.index')->with('success', 'Transaksi keluar berhasil disimpan dan stok diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingTransaction $outgoingTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingTransaction $itemout)
    {
        return view('action.itemout.edit', [
            'title' => 'Outgoing Transaction',
            'outgoing' => $itemout,
            'details' => $itemout->details,
            'items' => Item::all(),
            'categories' => Category::all(),    
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OutgoingTransaction $itemout)
{
    // 🔐 VALIDASI INPUT
    $validated = $request->validate([
        'code' => 'required|string|max:255|unique:outgoing_transaction,code,' . $itemout->id,
        'note' => 'nullable|string|max:255',
        'date' => 'required|date',
        'created_by' => 'required|string|max:255',
        'items' => 'nullable|array',
        'items.*.item_id' => 'required_with:items.*|exists:items,id',
        'items.*.quantity' => 'required_with:items.*|integer|min:1',
        'items.*.note' => 'nullable|string|max:255',
    ]);

    // 🔁 STEP 1: Kembalikan stok lama (ROLLBACK)
    foreach ($itemout->details as $oldDetail) {
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
    $itemout->details()->delete();

    // ✏️ STEP 4: Update data utama transaksi
    $itemout->update([
        'code' => $validated['code'],
        'note' => $validated['note'] ?? null,
        'date' => $validated['date'],
        'created_by' => $validated['created_by'],
    ]);

    // ➕ STEP 5: Tambahkan detail baru dan update stok
    if (!empty($validated['items'])) {
        foreach ($validated['items'] as $detail) {
            // Simpan detail transaksi
            OutgoingTransDetail::create([
                'outgoing_transaction_id' => $itemout->id,
                'item_id' => $detail['item_id'],
                'quantity' => $detail['quantity'],
                'note' => $detail['note'] ?? null,
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
    return redirect()->route('itemout.index')->with('success', 'Transaksi berhasil diperbarui dan stok disesuaikan.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingTransaction $itemout)
    {
         // 🔁 STEP 1: Kembalikan stok ke semula (kurangi stok yang pernah ditambahkan)
        foreach ($itemout->details as $detail) {
            $item = Item::find($detail->item_id);
            if ($item) {
                $item->stock = max(0, $item->stock - $detail->quantity); // Hindari nilai minus
                $item->save();
            }
        }

        // 🗑️ STEP 2: Hapus semua detail transaksi
        $itemout->details()->delete();

        // 🗑️ STEP 3: Hapus transaksi utama
        $itemout->delete();

        // ✅ STEP 4: Redirect kembali dengan pesan sukses
        return redirect()->route('itemout.index')->with('danger', 'Data transaksi berhasil dihapus dan stok telah disesuaikan.');
    }
}
