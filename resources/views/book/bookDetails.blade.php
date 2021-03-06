@extends('layouts.app')

@section('title')
PageGuild | {{ $book->title }} details
@endsection

@section('content')
    <div class="container scolor book-details">
        <div class="row">
            <div class="col">
                <img src="../../images/bookimg.webp" class="img-fluid book-cover" alt="Photo of book: {{ ucwords($book->title, ' ') }}">
            </div>
            <div class="col">
                <h1>{{ ucwords($book->title, ' ') }}</h1>

                <h3>de
                    @foreach ($authors as $author)
                    {{ ucwords($author->name, ' ') }} @if(count($authors) > 1), @endif
                    @endforeach
                </h3>

                <h3>PRICE</h3>
                <p>{{ $item->price }}€</p>

                <h3>SINOPSE</h3>
                <p>{{ $book->synopsis }}</p>

                <h3>DETALHES DO PRODUTO</h3>
                <p>ISBN: {{ $book->isbn }}</p>
                <p>Ano de edição: {{ $book->publication_year }}</p>
                <p>Editor: {{ ucwords($publisher, ' ') }}</p>
                <p>Idioma: {{ $language->name }}</p>
                <p>Dimensões: {{ $book->width }} x {{ $book->length }} x {{ $book->height }}</p>
                <p>Encadernação: {{ $book->bookbinding }}</p>
                <p>Paginas: {{ $book->num_pages }}</p>
                <p>Tipo de produto: {{ $itemType->type }}</p>

                <h3>GENEROS</h3>
                @foreach ($genres as $genre)
                    <p>{{ $genre->name }}</p>
                @endforeach

                <!-- Botão de comprar -->
                <form method="POST" action="{{ route('order.add_to_cart') }}">
                    @csrf
                    <input type="hidden" name="item_id" value={{ $item->id }}>
                    <input type="submit" class="buy-button btn btn-primary" value="{{ __('Adicionar ao carrinho') }}">

                    <div class="response">
                        @if(session('message'))
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
