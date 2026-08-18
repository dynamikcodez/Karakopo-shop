<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'order_id', 'reference', 'provider', 'amount', 'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
