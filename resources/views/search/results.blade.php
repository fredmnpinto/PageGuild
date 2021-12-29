@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')
    <!-- Filtros -->
    <div class="accordion" id="filterAccordion">
        <!-- Estou a passar os valores do accordion para ser dinamico. Ao inves de repetir sempre o mesmo HTML @author Gabriel -->
        
        <!-- Autor -->
        @include('includes.accordion', ['filterName' => 'Author', 'options' => $authorsFilterContent])

        <!-- Editor -->
        @include('includes.accordion', ['filterName' => 'Publisher', 'options' => $publisherFilterContent])
    </div>

    <!-- Ordenações -->

    <!-- Resultados -->
    <div class="container">
        <div class="row row-cols-3">
        @foreach ($results as $book) 
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
