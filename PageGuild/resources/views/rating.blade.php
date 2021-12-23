@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')

    @foreach ($ratings as $rating) 
        <p> {{ $rating->id }} </p>
    @endforeach
@endsection
