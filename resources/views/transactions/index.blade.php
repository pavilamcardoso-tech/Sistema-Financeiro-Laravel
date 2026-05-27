@extends('layout')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h2>Transações</h2>
    <a href="/transactions/create" class="btn btn-primary">+ Nova Transação</a>
</div>

<form method="GET" action="/transactions" class="mb-4">
    <div class="row align-items-end">
        <div class="col-md-3">
            <label class="form-label">Filtrar por mês</label>
            <input type="month" name="month" class="form-control" value="{{ $currentMonth }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
            <a href="/transactions" class="btn btn-outline-secondary">Limpar</a>
        </div>
    </div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $t)
        <tr>
            <td>{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</td>
            <td>{{ $t->description }}</td>
            <td>{{ $t->category->name }}</td>
            <td>
                <span class="badge {{ $t->type == 'income' ? 'bg-success' : 'bg-danger' }}">
                    {{ $t->type == 'income' ? 'Receita' : 'Despesa' }}
                </span>
            </td>
            <td>R$ {{ number_format($t->amount, 2, ',', '.') }}</td>
            <td>
                <a href="/transactions/{{ $t->id }}/edit" class="btn btn-sm btn-warning">Editar</a>
                <form action="/transactions/{{ $t->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Deletar?')">Deletar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">Nenhuma transação neste mês.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection