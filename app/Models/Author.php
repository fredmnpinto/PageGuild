<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "author";

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
        "name",
    ];

    const CREATED_AT = "registration_date";
    const UPDATED_AT = "update_date";

    public function book() {
        return $this->hasManyThrough(Book::class, AuthorBook::class);
    }
}
