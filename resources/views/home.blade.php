@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-3">
        @foreach ( $books as $book) 
            <div class="col my-5">
                <a class="navbar-brand" href="/details/{{ $book->item_id }}">
                    <img src="../../images/bookimg.webp" class="img-fluid" alt="Photo of book: {{ $book->title }}">
                    <p>{{ $book->title }}</p>
                </a>
            </div>
        @endforeach
        </div>
    </div>
@endsection
