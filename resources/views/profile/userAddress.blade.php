@extends('profile.profileView', ['activeNav' => 1])

@section('optionContent')
    <div class="row bg-white my-4 p-5">  
        <!-- Endereços ativados -->
    
            <h2>ENDERECOS ATIVOS</h2>
            @if($activeAddress->isEmpty())
                <h8>Não possuis nenhum endereço ativo</h8> 
            @else
            <table aria-label="Tabela de endereços desativados">
                <tr>
                    <th>Morada</th>
                    <th>Cidade</th>
                    <th>País</th>
                    <th>Desativar</th>
                    <th>Eliminar</th>
                </tr>
                @foreach($activeAddress as $address)
                <tr>
                    <td>{{ $address->address }}</td>
                    <td>{{ $address->city }}</td> 
                    <td>{{ $address->country }}</td> 
                    <td><a href="{{ route('desactivateAddress', ['address_id' =>  $address->id]) }}">Desativar</a></td> 
                    <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteAddress{{ $address->id }}">Eliminar</button></td>
                    <!-- Inclui um modal que e prenchido dinamicamente --> 
                    @include('includes.confirmDeleteAddressModal', ['address' => $address])
                </tr>
                @endforeach
            </table>
            @endif
       


        <!-- Endereços desativados -->
            
            <h2>ENDERECOS DESATIVADOS</h2>
            @if($deactiveAddress->isEmpty())
                <h8>Não possuis nenhum endereço desativo</h8> 
            @else
            <table aria-label="Tabela de endereços desativados">
                <tr>
                    <th>Morada</th>
                    <th>Cidade</th>
                        <th>País</th>
                        <th>Ativar</th>
                        <th>Eliminar</th>
                    </tr>
                    @foreach($deactiveAddress as $address)
                    <tr>
                        <td>{{ $address->address }}</td>
                        <td>{{ $address->city }}</td> 
                        <td>{{ $address->country }}</td> 
                        <td><a href="{{ route('activateAddress', ['address_id' =>  $address->id]) }}">Ativar</a></td> 
                        <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteAddress{{ $address->id }}">Eliminar</button></td>
                        <!-- Inclui um modal que e prenchido dinamicamente --> 
                        @include('includes.confirmDeleteAddressModal', ['address' => $address])
                    </tr>
                    @endforeach
                </table>
                @endif
            





            <!-- Criar um novo endereco -->
            
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAddress">Criar novo endereço</button>
            <!-- Inclui um modal que e prenchido dinamicamente --> 
            @include('includes.createAddressForm', ['cityList' => $cityList])
        </div>
    </form>
@endsection