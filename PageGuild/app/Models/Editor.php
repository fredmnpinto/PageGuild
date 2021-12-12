<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "editor";

    /**
     * Primary key dessa tabela
     *
     * @var string
     */
    protected $primaryKey = "id";

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "nome",
    ];
}
