<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "address";

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
    const CREATED_AT = "registration_date";
    const UPDATED_AT = "update_date";

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "city_id", "address", "flg_active",
        "flg_delete",
    ];

    public function user() {
        return $this->hasOne(User::class);
    }
}
