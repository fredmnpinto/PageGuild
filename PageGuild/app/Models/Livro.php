<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada a essa modal
     *
     * @var string
     */
    protected $table = "livro";

    /**
     * Primary key dessa tabela
     *
     * @var string
     */
    protected $primaryKey = "artigo_id";

    /**
     * Os atributos que poderão ser inseridos pela
     * UI da aplicação
     *
     * @var array
     */
    protected $fillable = [
        "titulo", "subtitulo", "sinopse",
        "ano_publicacao", "isbn", "ano_edicao",
        "idioma_id", "num_paginas", "dimensoes",
        "encadernacao"
    ];
}
