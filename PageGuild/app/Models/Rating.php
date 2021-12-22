<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = "rating";

    protected $fillable = [
        "comment", "item_id", "user_id"
    ];

    public $timestamps = false;

    public function book() {
        return $this->hasOne(Item::class);
    }

    public function user() {
        return $this->hasOne(User::class);
    }
}
