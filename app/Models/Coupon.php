<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'code',
        'discount_type',
        'discount_value',
        'free_shipping',
        'expiry_date',
        'status',
        'qty',
        'product_ids',
    ];

    protected $casts = [
        'product_ids' => 'array', // Handle product IDs as JSON array
        'expiry_date' => 'date',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
