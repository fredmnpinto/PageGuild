<?php

namespace App\Models;

use Gloudemans\Shoppingcart\Contracts\InstanceIdentifier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, InstanceIdentifier
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "users";

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
        "sex", "nif", "user_type_id", "img_path"
    ];

    public function address() {
        return $this->hasMany(Address::class);
    }

    public function shoppingCart() {
        return $this->belongsToMany(Item::class, ItemShoppingCart::class, 'user_id', 'item_id');
    }

    public function reservationListItem() {
        return $this->hasManyThrough(Item::class, ItemReservationList::class);
    }

    /* Funcao do ShoppingCart, é basicamente o id do shoppingcart */
    public function getInstanceIdentifier($options = null)
    {
        return $this->id;
    }

    /* Descontos a serem aplicados no ShoppingCart a tudo que o usuario for comprar,
    por defeito, como todos os user são iguais, fica-se a 0. */
    public function getInstanceGlobalDiscount($options = null)
    {
        return 0;
    }
}
