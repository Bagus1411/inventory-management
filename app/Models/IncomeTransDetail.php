<?php

namespace App\Models;

use App\Models\IncomingTransaction;
use Illuminate\Database\Eloquent\Model;

class IncomeTransDetail extends Model
{
    protected $guarded = [
        'id'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function incoming()
    {
        return $this->belongsTo(IncomingTransaction::class);
    }
}
