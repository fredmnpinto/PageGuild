@extends('profile.profileView', ['activeNav' => 2])

@section('optionContent')
    <!-- Ava -->
    <form method="POST" enctype="multipart/form-data" action="{{ route('updateProfileImage') }}">
    @csrf
    @method('POST')
        <div class="row terciary-color my-4 p-5">
            <h2>IMAGEM DE PERFIL</h2>

            @if ($user->img_path != null)
            <img class="col-3 p-3" src="{{ asset('storage/image/'.$user->img_path) }}" alt="Foto de perfil de {{ $user->name }}">
            @endif

            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02" name="image">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
            </div>
            @if ($message = Session::get('status'))
            <div class="alert alert-sucess">
                <p>{{ $message }}</p>
            </div>
            @endif

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submeter</button>
            </div>
        </div>
    </form>

    <!-- Informações do Utilizador -->
    <form method="POST" action="{{ route('updateInfo') }}">
    @csrf
    @method('POST')
        <div class="row terciary-color my-4 p-5">
            <h2>INFORMAÇÕES DO UTILIZADOR</h2>
            
            <!-- Nome -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="floatingInput" placeholder="Nome" value="{{ $user->name }}">
                <label for="floatingInput">Nome</label>
            </div>
            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email', 'userInfo') is-invalid @enderror" name="email" id="floatingInput" placeholder="name@example.com" value="{{ $user->email }}">
                <label for="floatingInput">E-mail</label>

                <!-- em caso de erro --> 
                @error('email', 'userInfo')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- NIF -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="nif" id="floatingInput" placeholder="NIF" value="{{ $user->nif }}">
                <label for="floatingInput">NIF</label>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Aplicar</button>
            </div>
        </div>
    </form>
@endsection