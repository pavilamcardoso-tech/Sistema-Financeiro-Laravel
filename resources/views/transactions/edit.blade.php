@extends('layout')

@section('content')
<h2 class="mb-4">Editar Transação</h2>

<form action="/transactions/{{ $transaction->id }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $transaction->description) }}" required>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Valor</label>
        <input type="number" name="amount" step="0.01" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $transaction->amount) }}" required>
        @error('amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
            <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Receita</option>
            <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Despesa</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Categoria</label>
        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
            <option value="">Selecione...</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Data</label>
        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $transaction->date) }}" required>
        @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="/transactions" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
