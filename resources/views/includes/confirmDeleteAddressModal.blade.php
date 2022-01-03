@extends('layouts.modal', ['modal_reference' => 'deleteAddress{{ $address->id }}'])

@section('header')
Eliminar address?
@endsection

@section('body')
<p class="text-black">Tens a certeza que pretendes eliminar {{ $address->address }} ?</p>
<p class="text-black">Esta operação <strong>não pode</strong> ser revertida!</p>
@endsection

@section('footer')
<a href="{{ route('deleteAddress', ['address_id' =>  $address->id]) }}">Eliminar</a>
@endsection