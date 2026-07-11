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
            --bg: #0a0a12; --surface: #111827; --surface2: #1a2236;
            --border: rgba(99,102,241,0.12); --border-hover: rgba(99,102,241,0.28);
            --accent: #6366f1; --accent-soft: rgba(99,102,241,0.08);
            --text: #f1f5f9; --muted: #94a3b8; --muted-dim: #64748b;
            --danger: #ef4444; --success: #22c55e;
            --sidebar-w: 250px; --font: 'Inter', system-ui, sans-serif;
            --radius-sm: 6px; --radius-md: 10px; --radius-lg: 14px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: var(--font); min-height: 100vh; font-size: 14px; -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w); background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex; flex-direction: column; z-index: 100;
        }
        .sidebar-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-brand .brand-icon {
            width: 34px; height: 34px; border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--accent), #818cf8);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; color: #fff; font-weight: 700;
            font-family: 'Courier New', monospace; letter-spacing: -0.02em;
        }
        .sidebar-brand .eyebrow {
            font-size: 0.62rem; letter-spacing: 0.16em; text-transform: uppercase;
            color: var(--accent); font-family: 'Courier New', monospace; line-height: 1;
        }
        .sidebar-brand .name {
            font-size: 0.92rem; font-weight: 700; color: var(--text); margin-top: 2px;
        }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-section {
            font-size: 0.62rem; letter-spacing: 0.13em; text-transform: uppercase;
            color: var(--muted-dim); padding: 12px 10px 7px;
            font-weight: 600;
        }
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 11px; border-radius: var(--radius-sm);
            color: var(--muted); transition: all 0.15s ease;
            margin-bottom: 2px; font-size: 0.86rem; font-weight: 500;
        }
        .nav-link i { width: 15px; text-align: center; font-size: 0.78rem; opacity: 0.75; }
        .nav-link:hover { background: var(--accent-soft); color: var(--text); }
        .nav-link:hover i { opacity: 1; }
        .nav-link.active { background: var(--accent-soft); color: var(--accent); }
        .nav-link.active i { opacity: 1; }

        .sidebar-footer {
            padding: 14px 12px; border-top: 1px solid var(--border);
        }
        .logout-form button {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 9px 11px; border-radius: var(--radius-sm);
            background: none; border: none; color: var(--muted);
            font-size: 0.86rem; font-family: var(--font); font-weight: 500;
            cursor: pointer; transition: all 0.15s ease;
        }
        .logout-form button:hover { background: rgba(239,68,68,0.08); color: var(--danger); }

        /* Main */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            padding: 16px 28px; border-bottom: 1px solid var(--border);
            background: rgba(17,24,39,0.85); backdrop-filter: blur(12px);
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 0.92rem; font-weight: 600; color: var(--text); }
        .topbar-user {
            font-size: 0.78rem; color: var(--muted);
            display: flex; align-items: center; gap: 8px;
        }
        .topbar-user-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), #818cf8);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.68rem; font-weight: 700; color: #fff;
        }
        .content { padding: 28px; flex: 1; }

        /* Page header */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 24px;
        }
        .page-title {
            font-size: 1.2rem; font-weight: 700;
            display: flex; align-items: center; gap: 10px;
        }
        .page-title::before {
            content: ''; width: 3px; height: 20px;
            background: var(--accent); border-radius: 2px;
        }

        /* Alerts */
        .alert {
            padding: 12px 16px; border-radius: var(--radius-sm);
            font-size: 0.84rem; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); color: #4ade80; }
        .alert-error { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); color: #f87171; }

        /* Card */
        .card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-lg); overflow: hidden;
        }
        .card-body { padding: 24px 28px; }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px; margin-bottom: 28px;
        }
        .stat-card {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: var(--radius-md); padding: 22px 24px;
            position: relative; overflow: hidden;
            transition: all 0.2s ease;
        }
        .stat-card:hover { border-color: var(--border-hover); transform: translateY(-2px); }
        .stat-card::after {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 2px; background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0; transition: opacity 0.2s;
        }
        .stat-card:hover::after { opacity: 1; }
        .stat-label {
            font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.1em;
            color: var(--muted-dim); margin-bottom: 8px; font-weight: 600;
        }
        .stat-value { font-size: 2rem; font-weight: 700; letter-spacing: -0.02em; }

        /* Table */
        .table-wrap { overflow-x: auto; border-radius: var(--radius-md); }
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left; padding: 11px 16px;
            font-size: 0.66rem; letter-spacing: 0.09em; text-transform: uppercase;
            color: var(--muted-dim); border-bottom: 1px solid var(--border);
            white-space: nowrap; font-weight: 600; background: rgba(0,0,0,0.15);
        }
        td { padding: 13px 16px; border-bottom: 1px solid rgba(99,102,241,0.06); vertical-align: middle; font-size: 0.88rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--accent-soft); }

        /* Badges */
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 99px;
            font-size: 0.68rem; font-weight: 600; letter-spacing: 0.04em;
        }
        .badge-green  { background: rgba(34,197,94,0.1); color: #4ade80; }
        .badge-gray   { background: rgba(148,163,184,0.1); color: var(--muted); }
        .badge-yellow { background: rgba(234,179,8,0.1); color: #facc15; }
        .badge-red    { background: rgba(239,68,68,0.1); color: #f87171; }
        .badge-blue   { background: rgba(99,102,241,0.12); color: #818cf8; }

        /* Buttons */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: var(--radius-sm);
            font-size: 0.83rem; font-weight: 500; cursor: pointer;
            border: none; transition: all 0.15s ease; font-family: var(--font);
        }
        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,0.25); }
        .btn-sm { padding: 5px 10px; font-size: 0.76rem; }
        .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        .btn-ghost:hover { color: var(--text); border-color: var(--border-hover); background: var(--accent-soft); }
        .btn-danger { background: rgba(239,68,68,0.08); color: var(--danger); border: 1px solid rgba(239,68,68,0.18); }
        .btn-danger:hover { background: rgba(239,68,68,0.16); }
        .actions { display: flex; gap: 6px; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block; font-size: 0.76rem; font-weight: 500;
            color: var(--muted); margin-bottom: 6px; letter-spacing: 0.02em;
        }
        input[type=text], input[type=email], input[type=number], input[type=password], input[type=datetime-local],
        select, textarea {
            width: 100%; padding: 10px 14px; background: var(--bg);
            border: 1px solid var(--border); border-radius: var(--radius-sm);
            color: var(--text); font-family: var(--font); font-size: 0.88rem;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        textarea { resize: vertical; min-height: 120px; }
        select[multiple] { min-height: 130px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-check { display: flex; align-items: center; gap: 10px; }
        .form-check input[type=checkbox] { width: auto; accent-color: var(--accent); width: 17px; height: 17px; }
        .form-check label { margin: 0; color: var(--text); font-size: 0.87rem; }
        .field-error { color: #f87171; font-size: 0.76rem; margin-top: 5px; }
        .form-hint { color: var(--muted-dim); font-size: 0.74rem; margin-top: 5px; }

        /* Pagination */
        .pagination { display: flex; gap: 5px; margin-top: 20px; flex-wrap: wrap; justify-content: center; }
        .pagination a, .pagination span {
            padding: 6px 12px; border-radius: var(--radius-sm);
            font-size: 0.82rem; border: 1px solid var(--border);
            color: var(--muted); transition: all 0.15s;
        }
        .pagination a:hover { border-color: var(--accent); color: var(--text); }
        .pagination span[aria-current] { background: var(--accent); color: #fff; border-color: var(--accent); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.25); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(99,102,241,0.4); }
    </style>
    @stack('styles')
</head>
<body>
<div style="display:flex; min-height:100vh;">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">A81</div>
            <div>
                <div class="eyebrow">// ADMIN</div>
                <div class="name">AREA81 Blog</div>
            </div>
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
            <span class="topbar-user">
                <div class="topbar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                {{ auth()->user()->name }}
            </span>
        </header>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
