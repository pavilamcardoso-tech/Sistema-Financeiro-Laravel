<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Controle Financeiro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background-color: #f1f5f9; }
        .sidebar { width: 250px; min-height: 100vh; background: #1e293b; position: fixed; top: 0; left: 0; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid #334155; }
        .sidebar-logo h1 { color: #fff; font-size: 18px; font-weight: 700; }
        .sidebar-logo p { color: #94a3b8; font-size: 12px; margin-top: 2px; }
        .sidebar-nav { padding: 16px 0; }
        .sidebar-nav a { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: #334155; color: #fff; }
        .sidebar-nav a svg { width: 18px; height: 18px; }
        .main-content { margin-left: 250px; min-height: 100vh; width: calc(100% - 250px); overflow-x: hidden; }
        .topbar { background: #fff; padding: 16px 32px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .topbar-title { font-size: 20px; font-weight: 600; color: #1e293b; }
        .topbar-user { display: flex; align-items: center; gap: 12px; }
        .topbar-user span { font-size: 14px; color: #64748b; }
        .topbar-user a { font-size: 14px; color: #ef4444; text-decoration: none; font-weight: 500; }
        .page-content { padding: 32px; max-width: 100%; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <h1>Controle Financeiro</h1>
            <p>Gestão pessoal</p>
        </div>
        <nav class="sidebar-nav">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="/transactions" class="{{ request()->is('transactions*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Transações
            </a>
            <a href="/categories" class="{{ request()->is('categories*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categorias
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-title">{{ $header ?? 'Dashboard' }}</div>
            <div class="topbar-user">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Sair</a>
                </form>
            </div>
        </div>
        <div class="page-content">
            {{ $slot }}
        </div>
    </div>
</body>
</html>