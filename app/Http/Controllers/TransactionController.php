<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    $query = Transaction::with('category')->orderBy('date', 'desc');

    if ($request->month) {
        $query->whereRaw("strftime('%Y-%m', date) = ?", [$request->month]);
    }

    $transactions = $query->get();
    $currentMonth = $request->month ?? date('Y-m');

    return view('transactions.index', compact('transactions', 'currentMonth'));
}

    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'description' => 'required|min:2|max:100',
        'amount' => 'required|numeric|min:0.01',
        'type' => 'required|in:income,expense',
        'category_id' => 'required|exists:categories,id',
        'date' => 'required|date',
    ], [
        'description.required' => 'A descrição é obrigatória.',
        'description.min' => 'A descrição deve ter pelo menos 2 caracteres.',
        'amount.required' => 'O valor é obrigatório.',
        'amount.numeric' => 'O valor deve ser numérico.',
        'amount.min' => 'O valor deve ser maior que zero.',
        'type.required' => 'O tipo é obrigatório.',
        'category_id.required' => 'A categoria é obrigatória.',
        'category_id.exists' => 'Categoria inválida.',
        'date.required' => 'A data é obrigatória.',
        'date.date' => 'Data inválida.',
    ]);

    Transaction::create($request->only('category_id', 'description', 'amount', 'type', 'date'));
    return redirect('/transactions')->with('success', 'Transação criada com sucesso!');
}


public function update(Request $request, Transaction $transaction)
{
    $request->validate([
        'description' => 'required|min:2|max:100',
        'amount' => 'required|numeric|min:0.01',
        'type' => 'required|in:income,expense',
        'category_id' => 'required|exists:categories,id',
        'date' => 'required|date',
    ], [
        'description.required' => 'A descrição é obrigatória.',
        'description.min' => 'A descrição deve ter pelo menos 2 caracteres.',
        'amount.required' => 'O valor é obrigatório.',
        'amount.numeric' => 'O valor deve ser numérico.',
        'amount.min' => 'O valor deve ser maior que zero.',
        'type.required' => 'O tipo é obrigatório.',
        'category_id.required' => 'A categoria é obrigatória.',
        'category_id.exists' => 'Categoria inválida.',
        'date.required' => 'A data é obrigatória.',
        'date.date' => 'Data inválida.',
    ]);

    $transaction->update($request->only('category_id', 'description', 'amount', 'type', 'date'));
    return redirect('/transactions')->with('success', 'Transação atualizada com sucesso!');
}


    public function edit(Transaction $transaction)
    {
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect('/transactions')->with('success', 'Transação deletada com sucesso!');
    }
}
