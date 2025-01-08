<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'logo',
        'favicon',
        'shop_name',
        'description',
        'email',
        'phone',
        'address',
        'whatsapp_number',
        'is_whatsapp',
        'fe_banner',
        'topbar_text',
        'is_topbar',
        'is_navbar',
        'customer_review_detail',
        'email_show',
        'email_required',
        'country_show',
        'country_required',
        'first_name_show',
        'first_name_required',
        'last_name_show',
        'last_name_required',
        'company_show',
        'company_required',
        'address_show',
        'address_required',
        'apartment_show',
        'apartment_required',
        'city_show',
        'city_required',
        'postal_code_show',
        'postal_code_required',
        'phone_show',
        'phone_required',
        'note_show',
        'note_required',
        'email_quick_buy',
        'country_quick_buy',
        'first_name_quick_buy',
        'last_name_quick_buy',
        'company_quick_buy',
        'address_quick_buy',
        'apartment_quick_buy',
        'city_quick_buy',
        'postal_code_quick_buy',
        'phone_quick_buy',
        'note_quick_buy',
    ];

    // Relationship with Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
