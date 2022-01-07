@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-3">
            <ul>
        @foreach ( $items as $item)
                <li>
                    <div class="item">
                        <span>{{ $item->name }}</span>
                        <span>{{ $item->price }}</span>
                        <form method="get" action="{{ route('showDetails', $item->id) }}">
                            <input type="submit" value="{{__("Show More")}}">
                        </form>
                    </div>
                </li>
        @endforeach
            </ul>
        </div>
    </div>
@endsection
