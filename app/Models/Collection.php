<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'collections';

    protected $guarded = ['id'];

}
