@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')
    <!-- Filtros -->
    <div class="accordion" id="filterAccordion">
        <h2 class="accordion-header" id="headingFilter">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
                FILTRAR POR
            </button>
        </h2>
        <div id="collapseFilter" class="accordion-collapse collapse" aria-labelledby="headingFilter">
            <div class="accordion-body">
            <!-- Estou a passar os valores do accordion para ser dinamico. Ao inves de repetir sempre o mesmo HTML @author Gabriel -->

                @foreach($possibleFilterOptions as $filter)
                    @include('includes.accordion', ['filterName' => $filter['name'], 'options' => $filter['options']])
                @endforeach

        </div>
    </div>

    <!-- Ordenações -->
    <div class="accordion" id="orderAccordion">
        <h2 class="accordion-header" id="headingFilter">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder" aria-expanded="true" aria-controls="collapseOrder">
                ORDENAR POR
            </button>
        </h2>
{{--        <div id="collapseOrder" class="accordion-collapse collapse" aria-labelledby="headingOrder">--}}
{{--            <div class="accordion-body bg-white">--}}
{{--                <!-- Ano (CRESCENTE) -->--}}
{{--                <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters']['author'] }}/{{ $url['filters'][1] }}/{{ $url['filters'][2] }}/{{ $url['filters'][3] }}/publication_year/asc">--}}
{{--                    <p class="text-dark">Ano de publicação (CRESCENTE)</p>--}}
{{--                </a>--}}

{{--                <!-- Ano (DECRESCENNTE) -->--}}
{{--                <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters'][0] }}/{{ $url['filters'][1] }}/{{ $url['filters'][2] }}/{{ $url['filters'][3] }}/publication_year/desc">--}}
{{--                    <p class="text-dark">Ano de publicação (DECRESCENNTE)</p>--}}
{{--                </a>--}}

{{--                <!-- Titulo (A-Z) -->--}}
{{--                <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters'][0] }}/{{ $url['filters'][1] }}/{{ $url['filters'][2] }}/{{ $url['filters'][3] }}/title/asc">--}}
{{--                    <p class="text-dark">Titulo (A-Z)</p>--}}
{{--                </a>--}}

{{--                <!-- Titulo (Z-A) -->--}}
{{--                <a class="navbar-brand" href="/search/results/orderFilter/{{ $url['searchQuery'] }}/{{ $url['filters'][0] }}/{{ $url['filters'][1] }}/{{ $url['filters'][2] }}/{{ $url['filters'][3] }}/title/desc">--}}
{{--                    <p class="text-dark">Titulo (Z-A)</p>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

    <!-- Resultados -->
    <div class="container">
        <div class="row row-cols-3">
        @foreach ($results as $item)
            <div class="col my-5">
                <a class="navbar-brand" href="/details/{{ $item->item_id }}">
                    <img src="/images/bookimg.webp" class="img-fluid" alt="Photo of book: {{ $item->item_name }}">
                    <p>{{ $item->item_name }}</p>
                </a>
            </div>
        @endforeach
        </div>
    </div>
@endsection
