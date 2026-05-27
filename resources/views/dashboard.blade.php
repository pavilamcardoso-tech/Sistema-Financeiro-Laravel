<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💰 Dashboard Financeiro
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-green-500 text-white rounded-lg p-4 shadow">
                    <p class="text-sm">Total Receitas</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($income, 2, ',', '.') }}</p>
                </div>
                <div class="bg-red-500 text-white rounded-lg p-4 shadow">
                    <p class="text-sm">Total Despesas</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($expense, 2, ',', '.') }}</p>
                </div>
                <div class="{{ $balance >= 0 ? 'bg-blue-500' : 'bg-yellow-500' }} text-white rounded-lg p-4 shadow">
                    <p class="text-sm">Saldo</p>
                    <p class="text-2xl font-bold">R$ {{ number_format($balance, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="col-span-2 bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold mb-2">Receitas x Despesas por Mês</h3>
                    <canvas id="barChart"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold mb-2">Distribuição</h3>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex justify-between mb-4">
                    <h3 class="font-semibold">Últimas Transações</h3>
                    <a href="/transactions" class="text-blue-500 text-sm">Ver todas →</a>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Data</th>
                            <th class="text-left py-2">Descrição</th>
                            <th class="text-left py-2">Categoria</th>
                            <th class="text-left py-2">Tipo</th>
                            <th class="text-left py-2">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                        <tr class="border-b">
                            <td class="py-2">{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $t->description }}</td>
                            <td class="py-2">{{ $t->category->name }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 rounded text-white text-xs {{ $t->type == 'income' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $t->type == 'income' ? 'Receita' : 'Despesa' }}
                                </span>
                            </td>
                            <td class="py-2">R$ {{ number_format($t->amount, 2, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4 text-gray-400">Nenhuma transação ainda.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

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
                    { label: 'Receitas', data: incomeData, backgroundColor: 'rgba(40, 167, 69, 0.7)' },
                    { label: 'Despesas', data: expenseData, backgroundColor: 'rgba(220, 53, 69, 0.7)' }
                ]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Receitas', 'Despesas'],
                datasets: [{ data: [{{ $income }}, {{ $expense }}], backgroundColor: ['rgba(40, 167, 69, 0.7)', 'rgba(220, 53, 69, 0.7)'] }]
            },
            options: { responsive: true }
        });
    </script>
</x-app-layout>
