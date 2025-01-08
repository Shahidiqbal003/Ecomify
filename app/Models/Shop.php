<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    // Mass assignment ke liye fields specify karein
    protected $fillable = ['id', 'name', 'domain', 'user_id'];

    // Relationship: Shop ka malik ek user hai
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
