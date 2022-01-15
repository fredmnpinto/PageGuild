@extends('profile.profileView', ['activeNav' => 3])

@section('optionContent')
    <div class="row rounded terciary-color my-4 p-5">
        <h2>{{ __("Suas encomendas") }}</h2>
        <table class="table rounded">
            <thead>
                <tr>
                    <th>{{ __('Id') }}</th>
                    <th>{{ __("Itens da sua encomenda") }}</th>
                    <th>{{ __("Data de registo") }}</th>
                    <th>{{ __('Estado da encomenda') }}</th>
                </tr>
            </thead>
            @forelse($ordersData as $details)
            <tr>
                <td>#{{ $details['order']->id }}</td>
                <td>
                        <div class="dropdown">
                            <button class="dropdown-toggle btn-outline-primary" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Items
                            </button>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach($details['items'] as $item)
                                    <a class="dropdown-item" href="{{ route('showDetails', $item->id) }}">
                                        {{ $item->amount }}x <strong>{{ $item->name }}</strong> ({{ $item->price }}€)
                                    </a>
                                @endforeach
                            </div>
                        </div>
                </td>
                <td>{{ $details['order']->registration_date }}</td>
                <td>{{ $details['status'] }}</td>
            </tr>
            @empty
                <h5>{{ __("Ainda não realizaste nenhuma compra...") }}</h5>
            @endforelse
        </table>
    </div>
@endsection
