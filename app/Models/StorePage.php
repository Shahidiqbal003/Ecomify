<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePage extends Model
{
    use HasFactory;

    protected $table = 'store_pages';

    protected $fillable = [
        'shop_id',
        'about',
        'contact',
        'faq',
        'how_to_order',
        'shipping_details',
        'payment_details',
        'privacy_policy',
        'return_refund',
        'terms_of_service',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}

