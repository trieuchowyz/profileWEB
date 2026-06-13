<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard – CV Builder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-bg:    #0F172A;
            --sidebar-width: 260px;
            --accent:        #6366F1;
            --accent-light:  #818CF8;
            --accent-muted:  #EEF2FF;
            --success:       #10B981;
            --warning:       #F59E0B;
            --danger:        #EF4444;
            --body-bg:       #F8FAFC;
            --card-bg:       #FFFFFF;
            --text-primary:  #0F172A;
            --text-secondary:#64748B;
            --border:        #E2E8F0;
            --radius:        12px;
            --shadow-sm:     0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.05);
            --shadow-md:     0 4px 16px rgba(0,0,0,.08);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.6;
        }

        /* ── SIDEBAR ──────────────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }

        .sidebar-logo .logo-mark {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 36px; height: 36px;
            background: var(--accent);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.3px;
        }

        .logo-text span {
            color: var(--accent-light);
        }

        .sidebar-section {
            padding: 20px 12px 4px;
        }

        .sidebar-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,.3);
            padding: 0 12px;
            margin-bottom: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,.55);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all .15s ease;
            cursor: pointer;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: rgba(255,255,255,.07);
            color: rgba(255,255,255,.9);
        }

        .nav-item.active {
            background: rgba(99,102,241,.25);
            color: #fff;
        }

        .nav-item.active .nav-icon {
            color: var(--accent-light);
        }

        .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 15px;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 20px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.07);
        }

        .admin-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,.06);
        }

        .admin-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .admin-info { flex: 1; min-width: 0; }
        .admin-name { font-size: 13px; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-role { font-size: 11px; color: rgba(255,255,255,.4); }

        /* ── MAIN ─────────────────────────────────────────────────────── */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ───────────────────────────────────────────────────── */
        .topbar {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .topbar-subtitle {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 1px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-icon {
            width: 38px; height: 38px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 16px;
            transition: all .15s;
        }

        .btn-icon:hover { background: var(--accent-muted); color: var(--accent); border-color: var(--accent-light); }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 9px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: opacity .15s;
        }

        .btn-primary:hover { opacity: .9; }

        /* ── CONTENT ──────────────────────────────────────────────────── */
        .content {
            padding: 28px 32px 48px;
            flex: 1;
        }

        /* ── STAT CARDS ───────────────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.indigo::before  { background: var(--accent); }
        .stat-card.green::before   { background: var(--success); }
        .stat-card.amber::before   { background: var(--warning); }
        .stat-card.rose::before    { background: var(--danger); }

        .stat-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .stat-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 19px;
        }

        .stat-icon.indigo { background: var(--accent-muted); }
        .stat-icon.green  { background: #ECFDF5; }
        .stat-icon.amber  { background: #FFFBEB; }
        .stat-icon.rose   { background: #FFF1F2; }

        .stat-trend {
            font-size: 12px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .stat-trend.up   { background: #ECFDF5; color: var(--success); }
        .stat-trend.down { background: #FFF1F2; color: var(--danger); }
        .stat-trend.flat { background: #F8FAFC; color: var(--text-secondary); }

        .stat-value {
            font-size: 30px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 5px;
            letter-spacing: -1px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .stat-sub {
            font-size: 11.5px;
            color: var(--text-secondary);
            margin-top: 10px;
        }

        .stat-sub strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* ── CHART ROW ────────────────────────────────────────────────── */
        .charts-row {
            display: grid;
            grid-template-columns: 1fr 1fr 340px;
            gap: 20px;
            margin-bottom: 28px;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .card-subtitle {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .card-body {
            padding: 16px 24px 20px;
        }

        .chart-wrap {
            position: relative;
            height: 180px;
        }

        /* ── DONUT CHART ──────────────────────────────────────────────── */
        .donut-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px 24px 20px;
        }

        .donut-canvas-wrap {
            position: relative;
            width: 160px; height: 160px;
        }

        .donut-label-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .donut-center-value { font-size: 26px; font-weight: 700; color: var(--text-primary); }
        .donut-center-label { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }

        .donut-legend {
            width: 100%;
            margin-top: 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid var(--border);
        }

        .legend-item:last-child { border-bottom: none; }

        .legend-left {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .legend-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-count {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ── TABLES ROW ───────────────────────────────────────────────── */
        .tables-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-secondary);
            padding: 10px 24px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            background: #FAFBFC;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody tr:hover { background: #F8FAFC; }

        tbody td {
            padding: 11px 24px;
            font-size: 13px;
            color: var(--text-primary);
            vertical-align: middle;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-sm {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: var(--accent-muted);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-name { font-weight: 600; font-size: 13px; }
        .user-email { font-size: 11.5px; color: var(--text-secondary); }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-public  { background: #ECFDF5; color: #059669; }
        .badge-private { background: #F1F5F9; color: #64748B; }
        .badge-active  { background: #EEF2FF; color: var(--accent); }

        .text-muted { color: var(--text-secondary); }
        .font-semibold { font-weight: 600; }

        /* ── POPULAR TEMPLATES BAR ────────────────────────────────────── */
        .template-row {
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .template-row:last-child { border-bottom: none; }

        .template-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .template-name { font-weight: 600; color: var(--text-primary); }
        .template-count { color: var(--text-secondary); }

        .progress-bar {
            height: 6px;
            background: var(--border);
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--accent);
            border-radius: 99px;
            transition: width .6s ease;
        }

        /* ── EMPTY STATE ──────────────────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 32px 24px;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .empty-state .icon { font-size: 32px; margin-bottom: 8px; }

        /* ── RESPONSIVE ───────────────────────────────────────────────── */
        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .charts-row { grid-template-columns: 1fr 1fr; }
            .charts-row .card:nth-child(3) { grid-column: span 2; }
        }

        @media (max-width: 768px) {
            :root { --sidebar-width: 0px; }
            .sidebar { display: none; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .charts-row, .tables-row { grid-template-columns: 1fr; }
            .content { padding: 20px 16px 40px; }
            .topbar { padding: 0 16px; }
        }
    </style>
</head>
<body>

    <!-- ══ SIDEBAR ══════════════════════════════════════════════════════ -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="/admin/dashboard" class="logo-mark">
                <div class="logo-icon">📄</div>
                <div class="logo-text">CV<span>Builder</span></div>
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Tổng quan</div>
            <a href="/admin/dashboard" class="nav-item active">
                <span class="nav-icon">⊞</span> Dashboard
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Quản lý</div>
            <a href="#" class="nav-item">
                <span class="nav-icon">👥</span> Người dùng
                <span class="nav-badge">{{ $totalUsers }}</span>
            </a>
            <a href="/admin/templates/view" class="nav-item">
                <span class="nav-icon">🎨</span> Templates
                <span class="nav-badge">{{ $totalTemplates }}</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">📋</span> Hồ sơ CV
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Hệ thống</div>
            <a href="#" class="nav-item">
                <span class="nav-icon">⚙️</span> Cài đặt
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="admin-card">
                <div class="admin-avatar">A</div>
                <div class="admin-info">
                    <div class="admin-name">Administrator</div>
                    <div class="admin-role">Super Admin</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- ══ MAIN ══════════════════════════════════════════════════════════ -->
    <div class="main">

        <!-- ── TOPBAR ───────────────────────────────────────────────── -->
        <header class="topbar">
            <div>
                <div class="topbar-title">Dashboard</div>
                <div class="topbar-subtitle">{{ now()->format('l, d/m/Y') }} · CV Builder Admin</div>
            </div>
            <div class="topbar-actions">
                <button class="btn-icon" title="Làm mới">↻</button>
                <button class="btn-primary">
                    + Thêm Template
                </button>
            </div>
        </header>

        <!-- ── CONTENT ──────────────────────────────────────────────── -->
        <main class="content">

            <!-- STAT CARDS -->
            <div class="stats-grid">

                <div class="stat-card indigo">
                    <div class="stat-header">
                        <div class="stat-icon indigo">👥</div>
                        <span class="stat-trend {{ $userGrowthPercent >= 0 ? 'up' : 'down' }}">
                            {{ $userGrowthPercent >= 0 ? '↑' : '↓' }} {{ abs($userGrowthPercent) }}%
                        </span>
                    </div>
                    <div class="stat-value" id="count-users">{{ $totalUsers }}</div>
                    <div class="stat-label">Tổng người dùng</div>
                    <div class="stat-sub">
                        <strong>+{{ $newUsersThisMonth }}</strong> trong 30 ngày qua
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-header">
                        <div class="stat-icon green">📄</div>
                        <span class="stat-trend {{ $resumeGrowthPercent >= 0 ? 'up' : 'down' }}">
                            {{ $resumeGrowthPercent >= 0 ? '↑' : '↓' }} {{ abs($resumeGrowthPercent) }}%
                        </span>
                    </div>
                    <div class="stat-value">{{ $totalResumes }}</div>
                    <div class="stat-label">Tổng hồ sơ CV</div>
                    <div class="stat-sub">
                        <strong>+{{ $newResumesThisMonth }}</strong> trong 30 ngày qua
                    </div>
                </div>

                <div class="stat-card amber">
                    <div class="stat-header">
                        <div class="stat-icon amber">🎨</div>
                        <span class="stat-trend flat">Templates</span>
                    </div>
                    <div class="stat-value">{{ $totalTemplates }}</div>
                    <div class="stat-label">Tổng templates</div>
                    <div class="stat-sub">
                        <strong>{{ $activeTemplates }}</strong> đang kích hoạt
                    </div>
                </div>

                <div class="stat-card rose">
                    <div class="stat-header">
                        <div class="stat-icon rose">🌐</div>
                        <span class="stat-trend up">Công khai</span>
                    </div>
                    <div class="stat-value">{{ $publicResumes }}</div>
                    <div class="stat-label">CV công khai</div>
                    <div class="stat-sub">
                        <strong>{{ $privateResumes }}</strong> CV riêng tư
                    </div>
                </div>

            </div>

            <!-- CHARTS ROW -->
            <div class="charts-row">

                <!-- User Chart -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Đăng ký người dùng</div>
                            <div class="card-subtitle">7 ngày gần nhất</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrap">
                            <canvas id="userChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Resume Chart -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">CV được tạo mới</div>
                            <div class="card-subtitle">7 ngày gần nhất</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-wrap">
                            <canvas id="resumeChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Donut: Public vs Private -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Trạng thái CV</div>
                            <div class="card-subtitle">Công khai / Riêng tư</div>
                        </div>
                    </div>
                    <div class="donut-wrap">
                        <div class="donut-canvas-wrap">
                            <canvas id="donutChart" width="160" height="160"></canvas>
                            <div class="donut-label-center">
                                <div class="donut-center-value">{{ $totalResumes }}</div>
                                <div class="donut-center-label">Tổng CV</div>
                            </div>
                        </div>
                        <div class="donut-legend">
                            <div class="legend-item">
                                <div class="legend-left">
                                    <div class="legend-dot" style="background:#6366F1"></div>
                                    Công khai
                                </div>
                                <span class="legend-count">{{ $publicResumes }}</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-left">
                                    <div class="legend-dot" style="background:#E2E8F0"></div>
                                    Riêng tư
                                </div>
                                <span class="legend-count">{{ $privateResumes }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- TABLES ROW -->
            <div class="tables-row">

                <!-- Recent Users -->
                <div class="card">
                    <div class="card-header" style="padding-bottom:16px">
                        <div>
                            <div class="card-title">Người dùng mới nhất</div>
                            <div class="card-subtitle">10 tài khoản vừa đăng ký</div>
                        </div>
                        <a href="#" style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:600;">Xem tất cả →</a>
                    </div>
                    @if($recentUsers->isEmpty())
                        <div class="empty-state">
                            <div class="icon">👤</div>
                            Chưa có người dùng nào
                        </div>
                    @else
                    <table>
                        <thead>
                            <tr>
                                <th>Người dùng</th>
                                <th>Vai trò</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="avatar-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="user-name">{{ $user->name }}</div>
                                            <div class="user-email">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $user->role === 'admin' ? 'badge-active' : 'badge-private' }}">
                                        {{ $user->role ?? 'user' }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

                <!-- Recent Resumes -->
                <div class="card">
                    <div class="card-header" style="padding-bottom:16px">
                        <div>
                            <div class="card-title">CV mới nhất</div>
                            <div class="card-subtitle">10 hồ sơ vừa được tạo</div>
                        </div>
                        <a href="#" style="font-size:12px;color:var(--accent);text-decoration:none;font-weight:600;">Xem tất cả →</a>
                    </div>
                    @if($recentResumes->isEmpty())
                        <div class="empty-state">
                            <div class="icon">📄</div>
                            Chưa có hồ sơ CV nào
                        </div>
                    @else
                    <table>
                        <thead>
                            <tr>
                                <th>Tiêu đề CV</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentResumes as $resume)
                            <tr>
                                <td>
                                    <div class="font-semibold">{{ Str::limit($resume->title, 28) }}</div>
                                    <div class="user-email">{{ optional($resume->users)->name ?? '—' }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $resume->is_public ? 'badge-public' : 'badge-private' }}">
                                        {{ $resume->is_public ? 'Công khai' : 'Riêng tư' }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $resume->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

            </div>

            <!-- POPULAR TEMPLATES -->
            @if($popularTemplates->isNotEmpty())
            <div style="margin-top:20px">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Templates phổ biến nhất</div>
                            <div class="card-subtitle">Xếp hạng theo số CV đang dùng</div>
                        </div>
                    </div>
                    <div class="card-body">
                        @php $maxCount = $popularTemplates->max('resume_count') ?: 1; @endphp
                        @foreach($popularTemplates as $template)
                        <div class="template-row">
                            <div class="template-header">
                                <span class="template-name">{{ $template->name }}</span>
                                <span class="template-count">{{ $template->resume_count }} CV</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:{{ round(($template->resume_count / $maxCount) * 100) }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </main>
    </div>

    <script>
        // ── Chart.js defaults ──────────────────────────────────────────────
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.color = '#64748B';

        const gradientBlue = (ctx) => {
            const g = ctx.createLinearGradient(0, 0, 0, 180);
            g.addColorStop(0, 'rgba(99,102,241,.25)');
            g.addColorStop(1, 'rgba(99,102,241,0)');
            return g;
        };

        const gradientGreen = (ctx) => {
            const g = ctx.createLinearGradient(0, 0, 0, 180);
            g.addColorStop(0, 'rgba(16,185,129,.25)');
            g.addColorStop(1, 'rgba(16,185,129,0)');
            return g;
        };

        // ── User Chart ────────────────────────────────────────────────────
        const userCtx   = document.getElementById('userChart').getContext('2d');
        const resumeCtx = document.getElementById('resumeChart').getContext('2d');

        const userLabels  = @json($userChartData->pluck('date'));
        const userCounts  = @json($userChartData->pluck('count'));
        const resumeLabels= @json($resumeChartData->pluck('date'));
        const resumeCounts= @json($resumeChartData->pluck('count'));

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
            scales: {
                x: { grid: { display: false }, border: { display: false },
                     ticks: { font: { size: 11 } } },
                y: { grid: { color: '#F1F5F9' }, border: { display: false, dash: [3,3] },
                     ticks: { stepSize: 1, font: { size: 11 }, precision: 0 } }
            },
            elements: { point: { radius: 3, hoverRadius: 5 } },
        };

        new Chart(userCtx, {
            type: 'line',
            data: {
                labels: userLabels,
                datasets: [{
                    data: userCounts,
                    borderColor: '#6366F1',
                    backgroundColor: gradientBlue(userCtx),
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: commonOptions,
        });

        new Chart(resumeCtx, {
            type: 'bar',
            data: {
                labels: resumeLabels,
                datasets: [{
                    data: resumeCounts,
                    backgroundColor: 'rgba(16,185,129,.15)',
                    borderColor: '#10B981',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: { ...commonOptions,
                elements: { ...commonOptions.elements, point: { radius: 0 } },
            },
        });

        // ── Donut Chart ───────────────────────────────────────────────────
        const total   = {{ $totalResumes }};
        const pub     = {{ $publicResumes }};
        const priv    = {{ $privateResumes }};

        new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Công khai', 'Riêng tư'],
                datasets: [{
                    data: total > 0 ? [pub, priv] : [0, 1],
                    backgroundColor: ['#6366F1', '#E2E8F0'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (c) => ` ${c.label}: ${c.parsed} CV`
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
