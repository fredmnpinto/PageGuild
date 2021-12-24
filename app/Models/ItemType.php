<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    protected $table = "item_type";

    public $timestamps = false;

    public function items() {
        return $this->hasMany(Item::class);
    }
}
