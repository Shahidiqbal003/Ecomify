<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $table = 'orders';

    protected $guarded = ['id'];

    // Relationship to the Shop model
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}

