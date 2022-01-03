<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenreBook extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "genre_book";

    /**
     * Primary key dessa tabela
     *
     * @var array
     */
    protected $primaryKey = ["book_item_id", "genre_id"];

    /**
     * Define que as primary keys não serão autoincrementadas
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "genre_id", "book_item_id"
    ];
}
