<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function coupon() {
        return $this->hasOne(Coupon::class);
    }

    public function item() {
        return $this->hasOne(Item::class);
    }
}
