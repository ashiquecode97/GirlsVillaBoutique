<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'address', 'city', 'pincode', 'phone',
        'payment_method', 'payment_verified', 'total_amount', 'status'
    ];

 public function items()
{
    return $this->hasMany(OrderItem::class);
}

}
