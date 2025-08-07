<?php

namespace App\Models;

use App\Models\Item;
use App\Models\OutgoingTransDetail;
use Illuminate\Database\Eloquent\Model;

class OutgoingTransaction extends Model
{

          protected $table = 'outgoing_transaction'; // <--- ini penting

          protected $guarded = ['id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function details()
    {
        return $this->hasMany(OutgoingTransDetail::class);
    }
}
