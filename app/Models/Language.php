<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = "language";

    public $timestamps = false;

    public function books() {
        return $this->hasMany(Book::class);
    }
}
