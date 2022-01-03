@extends('layouts.profile')

@section('title')
PageGuild | Profile 
@endsection

@section('sidebar')
    @include('includes.sidebar')
@endsection

@section('content')
    @yield('optionContent')
@endsection