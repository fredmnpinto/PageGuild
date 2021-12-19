<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "user";

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
    protected $dateFormat = "U";

    /**
     * Tabelas em que as timestamps sao guardadas
     */
    const CREATED_AT = "register_date";
    const UPDATED_AT = "update_date";

    /**
     * Os atributos que devem permanecer escondidos
     *
     * @var array
     */
    protected $hidden = [
      "password"
    ];

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "name", "email", "password",
        "sex", "nif"
    ];

    public function address() {
        return $this->hasMany(Address::class);
    }

    public function shoppingCartItem() {
        return $this->hasManyThrough(Item::class, ItemShoppingCart::class);
    }

    public function reservationListItem() {
        return $this->hasManyThrough(Item::class, ItemReservationList::class);
    }

}
