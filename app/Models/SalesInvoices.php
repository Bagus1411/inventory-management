<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoices extends Model
{
    use HasFactory;

    protected $table = 'sales_invoices';

    protected $guarded = ['id'];

    // Relasi ke customer (kalau ada tabel customers)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke detail invoice
    public function details()
    {
        return $this->hasMany(SalesInvoiceDetail::class, 'sales_invoice_id');
    }
}
