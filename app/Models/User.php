<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

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
    protected $dateFormat = "Ymd";

    /**
     * Tabelas em que as timestamps sao guardadas
     */
    const CREATED_AT = "registration_date";
    const UPDATED_AT = "update_date";

    /**
     * Os atributos que devem permanecer escondidos
     *
     * @var array
     */
    protected $hidden = [
      "password", "remember_token"
    ];

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "name", "email", "password", "username",
        "sex", "nif", "user_type_id"
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
