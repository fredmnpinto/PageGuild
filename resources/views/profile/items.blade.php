@extends('layouts.app')

@section('title')
PageGuild | Seus Itens
@endsection

@section('content')
    <div class="container">
        <div class="header">
            <h2>{{ __("Seus Itens") }}</h2>
        </div>
        <div class="row m-3">
            <a class="btn-lg btn-primary text-center" href="{{ route('book.create') }}">{{ __("Vender novo livro") }}</a>
        </div>
        @if(session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        @endif
        @if(session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
        <div class="row row-cols-3">
            @forelse ( $items as $item)
                <div class="col my-5">
                    <a class="navbar-brand book-link" href="/details/{{ $item->id }}">
                        <img src="../../images/bookimg.webp" class="img-fluid" alt="Photo of book: {{ ucwords($item->name, ' ') }}">
                        <p>{{ ucwords($item->name, ' ') }}</p>
                    </a>
                </div>
            @empty
                <h3>{{ __("Ainda não puseste nenhum item a venda") }}</h3>
            @endforelse
        </div>

        {{ $items->links() }}
    </div>
@endsection
