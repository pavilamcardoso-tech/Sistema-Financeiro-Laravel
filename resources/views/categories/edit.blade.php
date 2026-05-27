@extends('layout')

@section('content')
<h2 class="mb-4">Editar Categoria</h2>

<form action="/categories/{{ $category->id }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
            <option value="income" {{ old('type', $category->type) == 'income' ? 'selected' : '' }}>Receita</option>
            <option value="expense" {{ old('type', $category->type) == 'expense' ? 'selected' : '' }}>Despesa</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="/categories" class="btn btn-secondary">Cancelar</a>
</form>
@endsection