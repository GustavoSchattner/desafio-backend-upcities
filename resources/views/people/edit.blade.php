@extends('layouts.app')
@section('title', 'Editar Pessoa')

@section('content')
    @include('people._form')

    @if(isset($person))
        <section class="form-container danger-zone">
            <header class="form-header">
                <h3>Apagar Pessoa</h3>
            </header>
            
            <div class="danger-content">
                <p>Deseja remover permanentemente este registro?</p>
                
                <form action="{{ route('people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Esta ação é irreversível. Confirmar exclusão?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Excluir Pessoa
                    </button>
                </form>
            </div>
        </section>
    @endif
@endsection