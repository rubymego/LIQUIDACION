<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SANTRIX | Anexo Local')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0f2238;
            --navy-light: #1b3a5c;
            --blue: #1675b9;
            --cyan: #22a6c9;
            --background: #f3f6fa;
            --text: #243449;
            --muted: #8492a6;
            --border: #e8edf3;
            --green: #1d9e75;
            --green-bg: #e6f6ef;
            --amber: #b7791f;
            --amber-bg: #fdf3dc;
            --red: #c0392b;
            --red-bg: #fdecea;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: var(--background);
            color: var(--text);
        }
        a { color: inherit; }

        /* ---------- MENÚ LATERAL ---------- */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 265px;
            background: var(--navy);
            color: white;
            padding: 26px 16px;
            display: flex;
            flex-direction: column;
            z-index: 10;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 26px;
            border-bottom: 1px solid #ffffff18;
        }
        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            font-size: 22px;
            font-weight: 800;
        }
        .brand-name { font-size: 21px; font-weight: 800; letter-spacing: 1px; }
        .brand-subtitle { font-size: 10px; color: #a9c2d8; letter-spacing: 2px; }
        .menu-label {
            color: #7892aa;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.8px;
            margin: 28px 12px 10px;
        }
        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            margin: 3px 0;
            color: #c4d2df;
            text-decoration: none;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            transition: background .2s, color .2s;
        }
        .sidebar nav a .nav-icon { font-size: 19px; width: 22px; text-align: center; }
        .sidebar nav a:hover { background: #ffffff12; color: white; }
        .sidebar nav a.active {
            background: var(--navy-light);
            color: white;
            box-shadow: inset 3px 0 var(--cyan);
        }
        .sidebar-footer {
            margin-top: auto;
            padding: 18px 12px 0;
            border-top: 1px solid #ffffff18;
            color: #829bb1;
            font-size: 11px;
            line-height: 1.6;
        }

        /* ---------- ÁREA PRINCIPAL ---------- */
        .main-area { margin-left: 265px; min-height: 100vh; }
        .topbar {
            height: 72px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            position: sticky;
            top: 0;
            z-index: 5;
        }
        .topbar h1 { font-size: 19px; margin: 0; font-weight: 700; }
        .topbar-date { color: var(--muted); font-size: 12.5px; display: flex; align-items: center; gap: 6px; }
        .page-content { padding: 28px 35px; max-width: 1600px; margin: auto; }

        /* ---------- COMPONENTES ---------- */
        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 10px #19365208;
            margin-bottom: 20px;
        }
        .card-title { font-size: 15px; font-weight: 700; margin: 0 0 14px; }
        .eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--muted);
            text-transform: uppercase;
        }
        .hero-title { font-size: 20px; font-weight: 700; margin: 6px 0 4px; }
        .hero-sub { color: var(--muted); font-size: 13.5px; margin: 0; }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        .info-item {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .info-item .ico {
            width: 42px; height: 42px;
            border-radius: 11px;
            display: grid; place-items: center;
            background: #e8f2fa; color: var(--blue);
            font-size: 21px;
            flex-shrink: 0;
        }
        .info-item .lbl { font-size: 12px; color: var(--muted); }
        .info-item .val { font-size: 15px; font-weight: 700; margin-top: 2px; word-break: break-word; }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        .stat-card {
            border-radius: 14px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            text-decoration: none;
            transition: transform .15s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .ico { font-size: 34px; }
        .stat-card .lbl { font-size: 13px; font-weight: 500; }
        .stat-card .num { font-size: 34px; font-weight: 800; line-height: 1.1; }
        .stat-blue { background: #e3f0fb; color: #0e5a96; }
        .stat-green { background: var(--green-bg); color: #0f6b4e; }

        .badge {
            display: inline-block;
            padding: 3px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-ok { background: var(--green-bg); color: #0f6b4e; }
        .badge-warn { background: var(--amber-bg); color: var(--amber); }
        .badge-err { background: var(--red-bg); color: var(--red); }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 17px;
            border-radius: 9px;
            border: none;
            background: var(--blue);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 13.5px;
            cursor: pointer;
            transition: background .2s;
        }
        .btn:hover { background: var(--navy-light); color: white; }

        table { width: 100%; border-collapse: collapse; }
        th {
            background: #f6f8fb;
            color: #718096;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            text-align: left;
            padding: 13px;
        }
        td { padding: 13px; border-bottom: 1px solid var(--border); font-size: 13px; }
        tr:hover td { background: #f9fbfd; }

        input, select, textarea {
            border: 1px solid #dce3eb;
            border-radius: 8px;
            padding: 10px 12px;
            font-family: inherit;
            max-width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px #1675b922;
        }
        .alert { padding: 14px 17px; border-radius: 10px; margin-bottom: 18px; }
        .alert ul { margin: 0; padding-left: 18px; }
        .alert-success { background: #e8f7ef; color: #187747; }
        .alert-danger { background: #fff0f0; color: #b42318; }

        @media(max-width: 850px) {
            .sidebar { width: 75px; padding: 20px 9px; }
            .brand { justify-content: center; padding: 0 0 22px; }
            .brand-text, .menu-label, .nav-text, .sidebar-footer { display: none; }
            .sidebar nav a { justify-content: center; padding: 14px 5px; }
            .sidebar nav a .nav-icon { font-size: 22px; }
            .main-area { margin-left: 75px; }
            .topbar { padding: 0 18px; }
            .page-content { padding: 20px 15px; overflow-x: auto; }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { corePlugins: { preflight: false } }</script>
    <style>
        .card-panel { background:#fff; border:1px solid var(--border); border-radius:14px; padding:22px; box-shadow:0 2px 10px #19365208; }
        .stat-card { display:block; background:#fff; border:1px solid var(--border); border-radius:14px; padding:18px 20px; }
        .stat-label { font-size:12.5px; color:var(--muted); }
        .stat-value { font-size:28px; font-weight:800; margin-top:4px; }
        .detail-label { font-size:12px; color:var(--muted); }
        .detail-value { font-size:15px; font-weight:700; margin-top:2px; }
        .empty-state { text-align:center; padding:40px 20px; border:1px dashed #cfd8e3; border-radius:14px; background:#fafcfe; }
        .btn-primary, .btn-secondary { display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:10px 17px; border-radius:9px; font-size:13.5px; font-weight:600; text-decoration:none; cursor:pointer; transition:background .2s; }
        .btn-primary { background:var(--blue); color:#fff; border:1px solid var(--blue); }
        .btn-primary:hover { background:var(--navy-light); }
        .btn-secondary { background:#fff; color:var(--navy); border:1px solid #dce3eb; }
        .btn-secondary:hover { background:#f3f6fa; }
        .form-label { display:block; font-size:12.5px; font-weight:600; color:#5a6b80; margin-bottom:6px; }
        .form-input { width:100%; background:#fff; }
        input[type=checkbox] { width:auto; accent-color:var(--blue); }
    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">S</div>
            <div class="brand-text">
                <div class="brand-name">SANTRIX</div>
                <div class="brand-subtitle">ANEXO LOCAL</div>
            </div>
        </div>

        <div class="menu-label">MENÚ PRINCIPAL</div>
        <nav>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard nav-icon"></i><span class="nav-text">Dashboard</span>
            </a>
            <a href="{{ route('anexos.index') }}" class="{{ request()->routeIs('anexos.*') ? 'active' : '' }}">
                <i class="ti ti-settings nav-icon"></i><span class="nav-text">Configuración del Anexo</span>
            </a>
            <a href="{{ route('registros.index') }}" class="{{ request()->routeIs('registros.*') ? 'active' : '' }}">
                <i class="ti ti-table nav-icon"></i><span class="nav-text">Registros Anexo A</span>
            </a>
            <a href="{{ route('importaciones.create') }}" class="{{ request()->routeIs('importaciones.*') ? 'active' : '' }}">
                <i class="ti ti-upload nav-icon"></i><span class="nav-text">Importar Excel</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            SANTRIX · Sistema de gestión<br>
            Versión 1.0
        </div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <h1>@yield('page-title', 'Panel de control')</h1>
            <div class="topbar-date"><i class="ti ti-clock"></i> {{ now()->format('d/m/Y H:i') }}</div>
        </header>

        <section class="page-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </section>
    </main>

    @stack('scripts')
</body>
</html>
