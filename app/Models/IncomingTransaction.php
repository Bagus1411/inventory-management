<?php

namespace App\Models;

use App\Models\Item;
use App\Models\IncomeTransDetail;
use Illuminate\Database\Eloquent\Model;

class IncomingTransaction extends Model
{

      protected $table = 'incoming_transaction'; // <--- ini penting
    
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function details()
    {
        return $this->hasMany(IncomeTransDetail::class);
    }
}
