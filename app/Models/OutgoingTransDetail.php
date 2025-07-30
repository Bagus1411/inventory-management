<?php

namespace App\Models;

use App\Models\Item;
use App\Models\OutgoingTransaction;
use Illuminate\Database\Eloquent\Model;

class OutgoingTransDetail extends Model
{
    protected $guarded = [
        'id'
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function outgoing()
    {
        return $this->belongsTo(OutgoingTransaction::class);
    }
}

