<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $income = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        $transactions = Transaction::with('category')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        // Dados para o gráfico de barras por mês
        $monthlyData = Transaction::selectRaw("
            strftime('%m/%Y', date) as month,
            type,
            SUM(amount) as total
        ")
        ->groupBy('month', 'type')
        ->orderBy('date')
        ->get();

        $labels = $monthlyData->pluck('month')->unique()->values();
        $incomeByMonth = [];
        $expenseByMonth = [];

        foreach ($labels as $label) {
            $incomeByMonth[] = $monthlyData->where('month', $label)->where('type', 'income')->sum('total');
            $expenseByMonth[] = $monthlyData->where('month', $label)->where('type', 'expense')->sum('total');
        }

        return view('dashboard', compact(
            'income', 'expense', 'balance',
            'transactions', 'labels', 'incomeByMonth', 'expenseByMonth'
        ));
    }
}