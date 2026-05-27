<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; margin-bottom: 24px;">
        <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
            <p style="font-size: 13px; opacity: 0.85; margin-bottom: 8px; font-weight: 500;">TOTAL RECEITAS</p>
            <p style="font-size: 28px; font-weight: 700;">R$ {{ number_format($income, 2, ',', '.') }}</p>
        </div>
        <div style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
            <p style="font-size: 13px; opacity: 0.85; margin-bottom: 8px; font-weight: 500;">TOTAL DESPESAS</p>
            <p style="font-size: 28px; font-weight: 700;">R$ {{ number_format($expense, 2, ',', '.') }}</p>
        </div>
        <div style="background: {{ $balance >= 0 ? 'linear-gradient(135deg, #3b82f6, #2563eb)' : 'linear-gradient(135deg, #f59e0b, #d97706)' }}; color: white; border-radius: 12px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.07);">
            <p style="font-size: 13px; opacity: 0.85; margin-bottom: 8px; font-weight: 500;">SALDO ATUAL</p>
            <p style="font-size: 28px; font-weight: 700;">R$ {{ number_format($balance, 2, ',', '.') }}</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 20px; margin-bottom: 24px;">
        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.07);">
            <h3 style="font-size: 15px; font-weight: 600; color: #1e293b; margin-bottom: 16px;">Receitas x Despesas por Mês</h3>
            <canvas id="barChart"></canvas>
        </div>
        <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.07);">
            <h3 style="font-size: 15px; font-weight: 600; color: #1e293b; margin-bottom: 16px;">Distribuição</h3>
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.07);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 15px; font-weight: 600; color: #1e293b;">Últimas Transações</h3>
            <a href="/transactions" style="font-size: 13px; color: #3b82f6; text-decoration: none; font-weight: 500;">Ver todas →</a>
        </div>
        <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead>
                <tr style="border-bottom: 2px solid #f1f5f9;">
                    <th style="text-align: left; padding: 10px 12px; color: #64748b; font-weight: 600; font-size: 12px;">DATA</th>
                    <th style="text-align: left; padding: 10px 12px; color: #64748b; font-weight: 600; font-size: 12px;">DESCRIÇÃO</th>
                    <th style="text-align: left; padding: 10px 12px; color: #64748b; font-weight: 600; font-size: 12px;">CATEGORIA</th>
                    <th style="text-align: left; padding: 10px 12px; color: #64748b; font-weight: 600; font-size: 12px;">TIPO</th>
                    <th style="text-align: right; padding: 10px 12px; color: #64748b; font-weight: 600; font-size: 12px;">VALOR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr style="border-bottom: 1px solid #f8fafc;">
                    <td style="padding: 12px; color: #64748b;">{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</td>
                    <td style="padding: 12px; color: #1e293b; font-weight: 500;">{{ $t->description }}</td>
                    <td style="padding: 12px; color: #64748b;">{{ $t->category->name }}</td>
                    <td style="padding: 12px;">
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; background: {{ $t->type == 'income' ? '#dcfce7' : '#fee2e2' }}; color: {{ $t->type == 'income' ? '#16a34a' : '#dc2626' }};">
                            {{ $t->type == 'income' ? 'Receita' : 'Despesa' }}
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: right; font-weight: 600; color: {{ $t->type == 'income' ? '#16a34a' : '#dc2626' }};">
                        R$ {{ number_format($t->amount, 2, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding: 32px; text-align: center; color: #94a3b8;">Nenhuma transação ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
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
                    { label: 'Receitas', data: incomeData, backgroundColor: '#10b981', borderRadius: 4 },
                    { label: 'Despesas', data: expenseData, backgroundColor: '#ef4444', borderRadius: 4 }
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true } } }
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Receitas', 'Despesas'],
                datasets: [{ data: [{{ $income }}, {{ $expense }}], backgroundColor: ['#10b981', '#ef4444'], borderWidth: 0 }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } }, cutout: '70%' }
        });
    </script>
</x-app-layout>