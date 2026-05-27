<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|min:2|max:50',
        'type' => 'required|in:income,expense',
    ], [
        'name.required' => 'O nome é obrigatório.',
        'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
        'name.max' => 'O nome deve ter no máximo 50 caracteres.',
        'type.required' => 'O tipo é obrigatório.',
    ]);

    Category::create($request->only('name', 'type'));
    return redirect('/categories')->with('success', 'Categoria criada com sucesso!');
}

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|min:2|max:50',
        'type' => 'required|in:income,expense',
    ], [
        'name.required' => 'O nome é obrigatório.',
        'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
        'name.max' => 'O nome deve ter no máximo 50 caracteres.',
        'type.required' => 'O tipo é obrigatório.',
    ]);

    $category->update($request->only('name', 'type'));
    return redirect('/categories')->with('success', 'Categoria atualizada com sucesso!');
}

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/categories')->with('success', 'Categoria deletada com sucesso!');
    }
}