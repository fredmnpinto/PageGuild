@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')
    <div class="container scolor book-details">
        <div class="row">
            <div class="col">
                <img src="../../images/bookimg.webp" class="img-fluid book-cover" alt="Photo of book: {{ $book->title }}">
            </div>
            <div class="col">
                <h1>{{ $book->title }}</h1>

                <h3>de
                    @foreach ($authors as $author)
                    {{ $author->name }} @if($authors->count() > 1), @endif
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

                <div style="min-height: 10vh">
                    <h3>GENEROS</h3>
                        @foreach ($genres as $genre)
                            <p>{{ $genre->name }}</p>
                        @endforeach
                </div>

                <form action="{{route('order.checkout', $item)}}">
                    <input type="submit" class="buy-button" value="{{ __('Comprar') }}">
                </form>
            </div>
        </div>
    </div>
@endsection
