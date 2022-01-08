@extends('profile.profileView', ['activeNav' => 3])

@section('optionContent')
    <div class="row bg-white my-4 p-5">  
        <h2>USER ORDER'S</h2>
        <table>
            <tr>
                <th>Id</th>
                <th>Data de registro</th>
                <th>Estado</th>
            </tr>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->registration_date }}</td>
                <td>{{ $order->status }}</td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection