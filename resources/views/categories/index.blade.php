@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h2>Categorias</h2>
    <a href="/categories/create" class="btn btn-primary">+ Nova Categoria</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>
                <span class="badge {{ $category->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                    {{ $category->type == 'income' ? 'Receita' : 'Despesa' }}
                </span>
            </td>
            <td>
                <a href="/categories/{{ $category->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                <form action="/categories/{{ $category->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Deletar?')">Deletar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center">Nenhuma categoria ainda.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection