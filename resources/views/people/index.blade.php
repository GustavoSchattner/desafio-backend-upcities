@extends('layouts.app')
@section('title', 'Listagem de Pessoas') 

@section('content') 
    <main class="main-content">
        
        <div class="table-responsive">
            <table class="people-table">
                <thead class="people-table-header">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody class="people-table-body">
                    @forelse($people as $person)
                    <tr class="people-table-row">
                        <td class="people-table-data">{{ $person->name }}</td>
                        <td class="people-table-data">{{ $person->email }}</td>
                        <td class="people-table-data action-column">
                            <a href="{{ route('people.edit', $person->id) }}" class="people-edit-link" title="Visualizar">Editar</a>
                            <a href="{{ route('people.show', $person->id) }}" class="people-visualize-link" title="Visualizar">Visualizar</a>
                            <form action="{{ route('people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Tem certeza?');" class="people-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="people-delete-button">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="people-table-row">
                        <td class="people-table-data" colspan="3" style="text-align: center; padding: 2rem;">
                            Nenhum registro encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $people->links() }}
        </div>

    </main>
@endsection