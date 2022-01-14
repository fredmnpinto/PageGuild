@extends('layouts.app')

@section('title')
PageGuild | Home
@endsection

@section('content')
    <div class="container">
        @if(session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif
        <div class="row row-cols-3">
            @foreach ( $books as $book)
                <div class="col my-5">
                    <a class="navbar-brand bookLink" href="/details/{{ $book->item_id }}">
                        <img src="../../images/bookimg.webp" class="img-fluid" alt="Photo of book: {{ ucwords($book->title, ' ') }}">
                        <p>{{ ucwords($book->title, ' ') }}</p>
                    </a>
                </div>
            @endforeach
        </div>

        {{ $books->links() }}
    </div>
@endsection