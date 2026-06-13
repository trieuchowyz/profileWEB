<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - CV Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-bg: #f4f7fc;
            --sidebar-bg: #0a2540;
            --sidebar-hover: #1d3b5e;
            --text-muted: #8b9bb4;
        }
        body { background-color: var(--primary-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar {
            width: 260px; height: 100vh; background-color: var(--sidebar-bg);
            color: #fff; position: fixed; top: 0; left: 0; z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar .logo { font-size: 1.5rem; font-weight: 700; padding: 1.5rem; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-nav { list-style: none; padding: 0; margin-top: 1rem; }
        .sidebar-nav li a {
            display: flex; align-items: center; padding: 12px 24px; color: var(--text-muted);
            text-decoration: none; transition: 0.2s; font-weight: 500;
        }
        .sidebar-nav li a:hover, .sidebar-nav li a.active { background-color: var(--sidebar-hover); color: #fff; border-left: 4px solid #0d6efd; }
        .sidebar-nav li a i { width: 25px; font-size: 1.1rem; }
        .main-content { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .top-header { background: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: flex-end; align-items: center; }
        .content-body { padding: 30px; flex: 1; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.03); }
    </style>
    @stack('styles')
</head>
<body>

    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-file-signature text-primary"></i> CV Hub Admin
        </div>
        <ul class="sidebar-nav">
            <li><a href="/admin/dashboard" class="active"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="/admin/templates/view"><i class="fa-solid fa-layer-group"></i> Quản lý Template</a></li>
            <li><a href="#"><i class="fa-solid fa-users"></i> Quản lý User</a></li>
            <li><a href="#"><i class="fa-solid fa-cog"></i> Cài đặt</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=0D8ABC&color=fff" class="rounded-circle" width="32" height="32" alt="Admin">
                    <span>Admin</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-user me-2"></i> Hồ sơ</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Đăng xuất</a></li>
                </ul>
            </div>
        </header>

        <div class="content-body">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>