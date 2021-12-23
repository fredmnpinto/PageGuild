@extends('layouts.app')

@section('title')
LabWeb | Index
@endsection

@section('content')
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Sex</th>
            <th>Registration_Date</th>
            <th>NIF</th>
        </tr>
        
        @foreach ($users as $user) 
        <tr>
            <td> {{ $user->id }} </td>
            <td> {{ $user->name }} </td>
            <td> {{ $user->email }} </td>
            <td> {{ $user->password }} </td>
            <td> {{ $user->sex }} </td>
            <td> {{ $user->registration_date }} </td>
            <td> {{ $user->nif }} </td>
        </tr>
        @endforeach
    </table>
@endsection
