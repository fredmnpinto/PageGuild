<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "user_type";

    public $timestamps = false;

    public function users() {
        return $this->hasMany(User::class);
    }
}
