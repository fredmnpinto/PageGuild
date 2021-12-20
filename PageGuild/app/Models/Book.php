<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "book";

    /**
     * Primary key dessa tabela
     *
     * @var string
     */
    protected $primaryKey = "item_id";

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "title", "subtitle", "sinopsys",
        "publishing_year", "isbn", "edition_year",
        "language_id", "num_pages", "width", "length", "height",
        "bookbinding"
    ];

    public function item() {
        return $this->hasOne(Item::class);
    }

    public function author() {
        return $this->hasManyThrough(Author::class, BookAuthor::class);
    }

    public function publisher() {
        return $this->hasOneThrough(Publisher::class, BookPublisher::class);
    }

    public function genre() {
        return $this->hasManyThrough(Genre::class, BookGenre::class);
    }
}
