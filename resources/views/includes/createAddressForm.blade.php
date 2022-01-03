@extends('layouts.modal', ['modal_reference' => 'createAddress'])

@section('header')
<h5 class="modal-title" id="createAddressLabel">Cria um novo endereço</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
@endsection

@section('body')
<form method="post" action="{{ route('createAddress') }}">
    @csrf
    @method('POST')
    <!-- (Paises) Cidades -->
    <div class="form-floating mb-3">
        <select class="form-select" id="floatingSelect" name="city" aria-label="Floating label select example">
            @foreach($cityList as $city)
                <option value='{{ $city->city_id }}'>({{ $city->country }}) {{ $city->city }}</option>
            @endforeach
        </select>
        <label for="floatingSelect">Escolhe um País</label>
    </div>

    <!-- Endereço -->
    <div class="form-floating mb-3">
        <input type="text" class="form-control" name="address" id="floatingInput" placeholder="Endereço">
        <label for="floatingInput">Endereço</label>
    </div>

    <button type="submit" class="btn-primary">Criar</button>
</form>
@endsection

@section('footer')
@endsection