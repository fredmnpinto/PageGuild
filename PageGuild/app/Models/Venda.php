<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "venda";

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
    const CREATED_AT = "data_registo";

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "estado_venda"
    ];
}
