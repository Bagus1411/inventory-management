<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\IncomeTransDetail;
use App\Models\IncomingTransaction;

class IncomingTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('action.itemin.index', [
            'title' => 'Incoming Transaction',
            'incoming' => IncomingTransaction::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('action.itemin.create', [
            'title' => 'Incoming Transaction',
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
            'code' => 'required|string|max:255|unique:incoming_transaction,code',
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
        $transaction = IncomingTransaction::create([
            'code' => $validated['code'],
            'note' => $validated['note'] ?? null,
            'date' => $validated['date'],
            'created_by' => auth()->user()->name ?? 'System',
        ]);

        // Simpan detail & update stok
        foreach ($validated['items'] as $detail) {
            // Simpan detail
            IncomeTransDetail::create([
                'incoming_transaction_id' => $transaction->id,
                'item_id' => $detail['item_id'],
                // 'category_id' => $detail['category_id'],
                'quantity' => $detail['quantity'],
                'note' => $detail['note'] ?? null,
            ]);

            // Update stok
            $item = Item::find($detail['item_id']);
            if ($item) {
                $item->stock += $detail['quantity'];
                $item->save();
            }
        }

        return redirect()->route('itemin.index')->with('success', 'Transaksi berhasil disimpan dan stok diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingTransaction $incomingTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomingTransaction $itemin)
    {
        return view('action.itemin.edit', [
            'title' => 'Incoming Transaction',
            'incomingtransaction' => $itemin,
            'details' => $itemin->details,
            'items' => Item::all(),
            'Category' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomingTransaction $itemin)
    {
        // VALIDASI
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:incoming_transaction,code,' . $itemin->id,
            'note' => 'nullable|string|max:255',
            'date' => 'required|date',
            'created_by' => 'required|string|max:255',
            'items' => 'nullable|array',
            'items.*.item_id' => 'required_with:items.*|exists:items,id',
            // 'items.*.category_id' => 'required_with:items.*|exists:categories,id',
            'items.*.quantity' => 'required_with:items.*|integer|min:1',
            'items.*.note' => 'nullable|string|max:255',
        ]);


        // 🔁 STEP 1: Kembalikan stok barang dari detail lama
        foreach ($itemin->details as $oldDetail) {
            $item = Item::find($oldDetail->item_id);
            if ($item) {
                $item->stock = max(0, $item->stock - $oldDetail->quantity); // hindari minus
                $item->save();
            }
        }

        // 🗑️ STEP 2: Hapus semua detail lama
        $itemin->details()->delete();

        // 📝 STEP 3: Update transaksi utama
        $itemin->update([
            'code' => $validated['code'],
            'note' => $validated['note'] ?? null,
            'date' => $validated['date'],
            'created_by' => $validated['created_by'],
        ]);

        // ➕ STEP 4: Tambahkan detail baru jika ada
        if (!empty($validated['items'])) {
            foreach ($validated['items'] as $detail) {
                // Tambahkan detail
                IncomeTransDetail::create([
                    'incoming_transaction_id' => $itemin->id,
                    'item_id' => $detail['item_id'],
                    // 'category_id' => $detail['category_id'],
                    'quantity' => $detail['quantity'],
                    'note' => $detail['note'] ?? null,
                ]);

                // Update stok
                $item = Item::find($detail['item_id']);
                if ($item) {
                    $item->stock += $detail['quantity'];
                    $item->save();
                }
            }
        }

        return redirect()->route('itemin.index')->with('success', 'Data transaksi berhasil diperbarui dan stok telah disesuaikan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingTransaction $itemin)
    {
        // 🔁 STEP 1: Kembalikan stok ke semula (kurangi stok yang pernah ditambahkan)
        foreach ($itemin->details as $detail) {
            $item = Item::find($detail->item_id);
            if ($item) {
                $item->stock = max(0, $item->stock - $detail->quantity); // Hindari nilai minus
                $item->save();
            }
        }

        // 🗑️ STEP 2: Hapus semua detail transaksi
        $itemin->details()->delete();

        // 🗑️ STEP 3: Hapus transaksi utama
        $itemin->delete();

        // ✅ STEP 4: Redirect kembali dengan pesan sukses
        return redirect()->route('itemin.index')->with('danger', 'Data transaksi berhasil dihapus dan stok telah disesuaikan.');
    }
}
