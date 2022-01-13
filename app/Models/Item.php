<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
    */
    protected $table = "item";

    /**
     * Primary key dessa tabela
     *
     * @var string
    */
    protected $primaryKey = "id";

    /**
     * O formato de data usado na tabela
     *
     * @var string
     */
    protected $dateFormat = "Y-m-d H:i:s";

    /**
     * Tabelas em que as timestamps sao guardadas
     */
    const CREATED_AT = "registration_date";
    const UPDATED_AT = "update_date";


    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "name", "price"
    ];

    public function order() {
        return $this->hasMany(Order::class);
    }

    public function userShoppingCart() {
        return $this->hasManyThrough(User::class, ItemShoppingCart::class);
    }

    public function userWishlist() {
        return $this->hasManyThrough(User::class, ItemWishlish::class);
    }

    public function userReservationList() {
        return $this->hasManyThrough(User::class, ItemReservationList::class);
    }

}
