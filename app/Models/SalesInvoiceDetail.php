<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'sales_invoice_details';

    protected $guarded = ['id'];

    // Relasi ke invoice induk
    public function salesInvoice()
    {
        return $this->belongsTo(SalesInvoices::class, 'sales_invoice_id');
    }

    // Relasi ke item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
