@extends('layouts.app')

@section('title', 'Detalhes da Pessoa')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h2>Detalhes de {{ $person->name }}</h2>
    </div>

    <div class="details-grid">
        <div class="detail-item">
            <strong>Nome Completo:</strong>
            <p>{{ $person->name }}</p>
        </div>

        <div class="detail-item">
            <strong>CPF:</strong>
            <p>{{ $person->cpf }}</p>
        </div>

        <div class="detail-item">
            <strong>E-mail:</strong>
            <p>{{ $person->email }}</p>
        </div>

        <div class="detail-item">
            <strong>Data de Nascimento:</strong>
            {{-- Formatação de data padrão BR --}}
            <p>{{ \Carbon\Carbon::parse($person->birth_date)->format('d/m/Y') }}</p>
        </div>

        <div class="detail-item">
            <strong>Telefone:</strong>
            <p>{{ $person->phone_number }}</p>
        </div>

        <div class="detail-item">
            <strong>Endereço:</strong>
            <p>{{ $person->address }}</p>
        </div>

        <div class="detail-item">
            <strong>Estado (ID):</strong>
            {{-- Mostra uf_id ou state dependendo da sua versão do banco --}}
            <p>{{ $person->uf_id ?? $person->state }}</p>
        </div>

        <div class="detail-item">
            <strong>Cidade (ID):</strong>
            <p>{{ $person->city_id ?? $person->city }}</p>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1rem;">
        <a href="{{ route('people.index') }}" class="btn btn-secondary">Voltar</a>
        <a href="{{ route('people.edit', $person->id) }}" class="btn btn-primary">Editar</a>

        {{-- Botão de Excluir na tela de Visualização --}}
        <form action="{{ route('people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Tem certeza absoluta?');" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Excluir Registro</button>
        </form>
    </div>
</div>
@endsection