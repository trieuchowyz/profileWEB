@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('actions')
    <button class="btn-icon" title="Làm mới">↻</button>
@endsection

@section('content')
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
@endsection

@push('scripts')
    <script src="/admin/dashboard.js"></script>
@endpush