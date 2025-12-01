@extends('layouts.app')
@section('title', 'Editar Pessoa')

@section('content')

    <form action="{{ route('people.store') }}" method="POST">
        @csrf
        
        @include('people._form')
        
    </form>

@endsection