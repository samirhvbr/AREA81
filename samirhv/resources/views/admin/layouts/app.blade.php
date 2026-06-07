<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — @yield('title', 'Painel') | AREA81</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/canvas/fonts/font-awesome/css/all.min.css') }}">
    <style>
        :root {
            --bg: #0d0d14; --surface: #111827; --surface2: #1a2236;
            --border: rgba(99,102,241,0.15); --accent: #6366f1;
            --accent-dim: rgba(99,102,241,0.08); --text: #f1f5f9;
            --muted: #94a3b8; --danger: #ef4444; --success: #22c55e;
            --sidebar-w: 240px; --font: 'Inter', system-ui, sans-serif;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: var(--font); min-height: 100vh; font-size: 14px; }
        a { color: inherit; text-decoration: none; }

        /* Sidebar */
        .sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-w); background: var(--surface); border-right: 1px solid var(--border); display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 20px 18px 16px; border-bottom: 1px solid var(--border); }
        .sidebar-brand .eyebrow { font-size: 0.65rem; letter-spacing: 0.18em; color: var(--accent); font-family: 'Courier New', monospace; }
        .sidebar-brand .name { font-size: 0.9rem; font-weight: 700; color: var(--text); margin-top: 2px; }
        .sidebar-nav { flex: 1; padding: 12px 10px; overflow-y: auto; }
        .nav-section { font-size: 0.6rem; letter-spacing: 0.14em; text-transform: uppercase; color: var(--muted); padding: 10px 8px 4px; }
        .nav-link { display: flex; align-items: center; gap: 9px; padding: 8px 10px; border-radius: 7px; color: var(--muted); transition: all 0.15s; margin-bottom: 1px; font-size: 0.85rem; }
        .nav-link i { width: 14px; text-align: center; font-size: 0.75rem; }
        .nav-link:hover { background: var(--accent-dim); color: var(--text); }
        .nav-link.active { background: var(--accent-dim); color: var(--accent); }
        .sidebar-footer { padding: 12px 10px; border-top: 1px solid var(--border); }
        .logout-form button { display: flex; align-items: center; gap: 9px; width: 100%; padding: 8px 10px; border-radius: 7px; background: none; border: none; color: var(--muted); font-size: 0.85rem; font-family: var(--font); cursor: pointer; transition: all 0.15s; }
        .logout-form button:hover { background: rgba(239,68,68,0.1); color: var(--danger); }

        /* Main */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { padding: 14px 24px; border-bottom: 1px solid var(--border); background: var(--surface); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 0.9rem; font-weight: 600; color: var(--text); }
        .topbar-user { font-size: 0.78rem; color: var(--muted); }
        .content { padding: 24px; flex: 1; }

        /* Page header */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .page-title { font-size: 1.15rem; font-weight: 700; }

        /* Alerts */
        .alert { padding: 10px 14px; border-radius: 8px; font-size: 0.82rem; margin-bottom: 18px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25); color: #4ade80; }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #f87171; }

        /* Card */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; }
        .card-body { padding: 20px 24px; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 14px; margin-bottom: 24px; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 18px 20px; }
        .stat-label { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); margin-bottom: 6px; }
        .stat-value { font-size: 1.9rem; font-weight: 700; }

        /* Table */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 9px 14px; font-size: 0.66rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--border); white-space: nowrap; }
        td { padding: 11px 14px; border-bottom: 1px solid rgba(99,102,241,0.06); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--accent-dim); }

        /* Badges */
        .badge { display: inline-block; padding: 2px 9px; border-radius: 99px; font-size: 0.68rem; font-weight: 600; letter-spacing: 0.04em; }
        .badge-green  { background: rgba(34,197,94,0.12); color: #4ade80; }
        .badge-gray   { background: rgba(148,163,184,0.12); color: var(--muted); }
        .badge-yellow { background: rgba(234,179,8,0.12); color: #facc15; }
        .badge-red    { background: rgba(239,68,68,0.12); color: #f87171; }
        .badge-blue   { background: rgba(99,102,241,0.15); color: #818cf8; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 7px; font-size: 0.82rem; font-weight: 500; cursor: pointer; border: none; transition: all 0.15s; font-family: var(--font); }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #4f46e5; }
        .btn-sm { padding: 4px 9px; font-size: 0.75rem; }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { color: var(--text); border-color: rgba(99,102,241,0.4); }
        .btn-danger { background: rgba(239,68,68,0.12); color: var(--danger); border: 1px solid rgba(239,68,68,0.25); }
        .btn-danger:hover { background: rgba(239,68,68,0.22); }
        .actions { display: flex; gap: 6px; }

        /* Forms */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 0.75rem; font-weight: 500; color: var(--muted); margin-bottom: 5px; letter-spacing: 0.03em; }
        input[type=text], input[type=email], input[type=number], input[type=password], input[type=datetime-local],
        select, textarea {
            width: 100%; padding: 9px 12px; background: var(--bg); border: 1px solid var(--border);
            border-radius: 7px; color: var(--text); font-family: var(--font); font-size: 0.875rem;
            transition: border-color 0.15s;
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--accent); }
        textarea { resize: vertical; min-height: 110px; }
        select[multiple] { min-height: 120px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-check { display: flex; align-items: center; gap: 8px; }
        .form-check input[type=checkbox] { width: auto; accent-color: var(--accent); width: 16px; height: 16px; }
        .form-check label { margin: 0; color: var(--text); font-size: 0.85rem; }
        .field-error { color: #f87171; font-size: 0.75rem; margin-top: 4px; }
        .form-hint { color: var(--muted); font-size: 0.72rem; margin-top: 4px; }

        /* Pagination */
        .pagination { display: flex; gap: 4px; margin-top: 18px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 5px 10px; border-radius: 6px; font-size: 0.8rem; border: 1px solid var(--border); color: var(--muted); }
        .pagination a:hover { border-color: var(--accent); color: var(--text); }
        .pagination span[aria-current] { background: var(--accent); color: #fff; border-color: var(--accent); }
    </style>
    @stack('styles')
</head>
<body>
<div style="display:flex; min-height:100vh;">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="eyebrow">// ADMIN</div>
            <div class="name">AREA81 Blog</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Geral</div>
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>

            <div class="nav-section">Conteúdo</div>
            <a href="{{ route('admin.posts.index') }}"
               class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i> Posts
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-folder"></i> Categorias
            </a>
            <a href="{{ route('admin.tags.index') }}"
               class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Tags
            </a>

            <div class="nav-section">Audiência</div>
            <a href="{{ route('admin.subscribers.index') }}"
               class="nav-link {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope"></i> Assinantes
            </a>

            <div class="nav-section">Site</div>
            <a href="{{ route('home') }}" target="_blank" class="nav-link">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Ver blog
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                @csrf
                <button type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i> Sair
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">@yield('title', 'Painel')</span>
            <span class="topbar-user">{{ auth()->user()->name }}</span>
        </header>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-check"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
