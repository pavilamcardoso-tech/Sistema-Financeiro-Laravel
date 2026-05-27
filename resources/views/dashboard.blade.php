@extends('layout')

@section('content')
<h2 class="mb-4">Dashboard</h2>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Receitas</h5>
                <h3>R$ {{ number_format($income, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title">Total Despesas</h5>
                <h3>R$ {{ number_format($expense, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white {{ $balance >= 0 ? 'bg-primary' : 'bg-warning' }}">
            <div class="card-body">
                <h5 class="card-title">Saldo</h5>
                <h3>R$ {{ number_format($balance, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Receitas x Despesas por Mês</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Distribuição</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<h4>Últimas Transações</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Categoria</th>
            <th>Tipo</th>
            <th>Valor</th>
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
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">Nenhuma transação ainda.</td></tr>
        @endforelse
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const incomeData = @json($incomeByMonth);
    const expenseData = @json($expenseByMonth);

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Receitas',
                    data: incomeData,
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                },
                {
                    label: 'Despesas',
                    data: expenseData,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Receitas', 'Despesas'],
            datasets: [{
                data: [{{ $income }}, {{ $expense }}],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(220, 53, 69, 0.7)'
                ]
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection