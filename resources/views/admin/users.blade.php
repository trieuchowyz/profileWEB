@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')
@section('page_title', 'Người dùng')
@section('page_subtitle', 'Danh sách tài khoản hệ thống · CV Builder Admin')

@section('content')

{{-- Alert Thông báo --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Thống kê nhanh --}}
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="text-muted small fw-semibold text-uppercase">Tổng người dùng đăng ký</div>
            <div class="fs-2 fw-bold text-dark">{{ $totalUsers }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="text-muted small fw-semibold text-uppercase">Tổng Templates hệ thống</div>
            <div class="fs-2 fw-bold text-primary">{{ $totalTemplates }}</div>
        </div>
    </div>
</div>

{{-- Bộ lọc & Tìm kiếm --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label text-muted small mb-1">Tìm kiếm người dùng</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Nhập tên hoặc email..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary px-4">🔍 Tìm kiếm</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary ms-2">Làm mới</a>
            </div>
        </form>
    </div>
</div>

{{-- Bảng Danh sách Người dùng --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width:50px">#</th>
                    <th style="width:60px">Avatar</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th class="text-center">Số CV đã tạo</th>
                    <th>Ngày đăng ký</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}"
                                 alt="{{ $user->name }}"
                                 class="rounded-circle border" style="width:40px;height:40px;object-fit:cover">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                 style="width:40px;height:40px;font-size:16px">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold text-dark">{{ $user->name }}</td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border">{{ $user->resumes_count ?? 0 }} CV</span>
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-outline-danger"
                            data-id="{{ $user->id }}"
                            onclick="confirmDeleteUser(this.dataset.id)">
                            🗑 Xoá
                        </button>
                        <form id="delete-user-{{ $user->id }}"
                              action="{{ route('admin.users.destroy', $user) }}"
                              method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <div class="fs-1 mb-2">👤</div>
                        Không tìm thấy người dùng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function confirmDeleteUser(id) {
    if (confirm('⚠️ Bạn chắc chắn muốn xoá người dùng này? TẤT CẢ CV của người này cũng sẽ bị xoá vĩnh viễn!')) {
        document.getElementById('delete-user-' + id).submit();
    }
}
</script>
@endpush