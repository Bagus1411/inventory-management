<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Models\IncomingTransaction;
use App\Models\IncomeTransDetail;
use App\Models\OutgoingTransaction;
use App\Models\OutgoingTransDetail;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $guarded = [
        'id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomingTransactions()
    {
        return $this->hasMany(IncomingTransaction::class);
    }

    public function incomeTransDetails()
    {
        return $this->hasMany(IncomeTransDetail::class);
    }

    public function outgoingTransactions()
    {
        return $this->hasMany(OutgoingTransaction::class);
    }

    public function outgoingTransDetails()
    {
        return $this->hasMany(OutgoingTransDetail::class);
    }
}
