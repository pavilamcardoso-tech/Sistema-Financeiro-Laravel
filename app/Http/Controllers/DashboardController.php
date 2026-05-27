<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $income = Transaction::where('user_id', $userId)->where('type', 'income')->sum('amount');
        $expense = Transaction::where('user_id', $userId)->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        $transactions = Transaction::with('category')
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $monthlyData = Transaction::where('user_id', $userId)
            ->selectRaw("strftime('%m/%Y', date) as month, type, SUM(amount) as total")
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