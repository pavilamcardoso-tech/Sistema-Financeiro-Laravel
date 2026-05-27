@extends('layout')

@section('content')
<h2 class="mb-4">Nova Categoria</h2>

<form action="/categories" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Tipo</label>
        <select name="type" class="form-control @error('type') is-invalid @enderror" required>
            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Receita</option>
            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Despesa</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="/categories" class="btn btn-secondary">Cancelar</a>
</form>
@endsection