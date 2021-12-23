<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    const CREATED_AT = "registration_date";
    const UPDATED_AT = false;

    public function order() {
        return $this->hasMany(Order::class);
    }

    public function item() {
        return $this->hasManyThrough(Item::class, CouponItem::class);
    }
}
