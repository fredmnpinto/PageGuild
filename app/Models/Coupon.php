<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupon';

    protected $primaryKey = 'id';

    protected $dateFormat = 'Ymd';

    public $timestamps = false;

    protected $hidden = ['code'];

    protected $fillable = [
        'code', 'start_date', 'end_date',
        'discount', 'description'
        ];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function items() {
        return $this->hasManyThrough(Item::class, CouponItem::class);
    }
}
