<?php

namespace App\Models;

use App\Models\Item;
use App\Models\OutgoingTransDetail;
use Illuminate\Database\Eloquent\Model;

class OutgoingTransaction extends Model
{
    protected $fillable = [
        'items_id',
        'users_id',
        'category_id',
        'quantity',
        'date'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function details()
    {
        return $this->hasMany(OutgoingTransDetail::class);
    }
}
