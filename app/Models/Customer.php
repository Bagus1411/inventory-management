<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function salesInvoices()
    {
        return $this->hasMany(SalesInvoices::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            // Cari kode terakhir
            $latestCustomer = self::latest('id')->first();

            if ($latestCustomer && $latestCustomer->code) {
                // Ambil angka terakhir dari kode
                $lastNumber = (int) str_replace('CUST-', '', $latestCustomer->code);
                $newNumber  = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            // Format: CUST-0001, CUST-0002, dst
            $customer->code = 'CUST-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        });
    }

}
