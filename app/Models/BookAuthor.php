<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "author_book";

    /**
     * Primary key dessa tabela
     *
     * @var array
     */
    protected $primaryKey = ["item_id", "author_id"];

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
        "item_id", "author_id"
    ];

    public function book() {
        return $this->hasOne(Book::class, 'item_id', 'item_id');
    }

    public function author() {
        return $this->hasOne(Author::class);
    }
}
