<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') – CV Builder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    {{-- css bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/style.css">
    @stack('styles')
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
            <a href="/admin/dashboard" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⊞</span> Dashboard
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Quản lý</div>
            <a href="/admin/users" class="nav-item">
                <span class="nav-icon">👥</span> Người dùng
                <span class="nav-badge">{{ $totalUsers ?? 0 }}</span>
            </a>
            <a href="/admin/templates" class="nav-item {{ request()->is('admin/templates*') ? 'active' : '' }}">
                <span class="nav-icon">🎨</span> Templates
                <span class="nav-badge">{{ $totalTemplates ?? 0 }}</span>
            </a>
            <a href="/admin/resumes" class="nav-item {{ request()->is('admin/resumes*') ? 'active' : '' }}">
                <span class="nav-icon">📋</span> Hồ sơ CV
            </a>
        </div>

        <!-- <div class="sidebar-section">
            <div class="sidebar-label">Hệ thống</div>
            <a href="/admin/settings" class="nav-item">
                <span class="nav-icon">⚙️</span> Cài đặt
            </a>
        </div> -->

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
                <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
                <div class="topbar-subtitle">@yield('page_subtitle', now()->format('l, d/m/Y') . ' · CV Builder Admin')</div>
            </div>
            <div class="topbar-actions">
                @yield('actions')
            </div>
        </header>

        <!-- ── CONTENT ──────────────────────────────────────────────── -->
        <main class="content">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>