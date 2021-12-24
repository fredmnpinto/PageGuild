@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <img src="../../images/bookimg.webp" class="img-fluid" alt="Photo of book: {{ $book->title }}">
            </div>
            <div class="col">
                <h1>{{ $book->title }}</h1>

                <h3>de 
                    @foreach ($authors as $author)
                    {{ $author }}
                    @endforeach
                </h3>

                <h3>PRICE</h3>
                <p>{{ $item->price }}</p>

                <h3>SINOPSE</h3>
                <p>{{ $book->synopsis }}</p>

                <h3>DETALHES DO PRODUTO</h3>
                <p>ISBN: {{ $book->isbn }}</p>
                <p>Ano de edição: {{ $book->publication_year }}</p>
                <p>Editor: {{ $publisher }}</p>
                <p>Idioma: {{ $language->name }}</p>
                <p>Dimensões: {{ $book->width }} x {{ $book->length }} x {{ $book->height }}</p>
                <p>Encadernação: {{ $book->bookbinding }}</p>
                <p>Paginas: {{ $book->num_pages }}</p>
                <p>Tipo de produto: {{ $itemType->type }}</p>
            </div>
        </div>
    </div>
@endsection
