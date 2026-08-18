<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'customer_name', 'customer_email', 
        'customer_phone', 'delivery_address', 'city', 'state', 
        'delivery_instructions', 'subtotal', 'delivery_fee', 'total', 
        'payment_status', 'order_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
