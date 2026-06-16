@extends('layouts.admin')

@section('title', 'Quản lý Hồ sơ CV')
@section('page_title', 'Hồ sơ CV')
@section('page_subtitle', 'Danh sách toàn bộ CV được tạo trên hệ thống')

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
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="text-muted small fw-semibold text-uppercase">Tổng số CV</div>
            <div class="fs-2 fw-bold text-dark">{{ $totalResumes ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="text-muted small fw-semibold text-uppercase">CV Công khai</div>
            <div class="fs-2 fw-bold text-success">{{ $publicResumes ?? 0 }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="text-muted small fw-semibold text-uppercase">CV Riêng tư</div>
            <div class="fs-2 fw-bold text-secondary">{{ $privateResumes ?? 0 }}</div>
        </div>
    </div>
</div>

{{-- Bộ lọc & Tìm kiếm --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.resumes.index') }}" class="row g-2 align-items-end">
            <div class="col-md-8">
                <label class="form-label text-muted small mb-1">Tìm kiếm hồ sơ</label>
                <input type="text" name="search" class="form-control"
                       placeholder="Nhập tiêu đề CV hoặc tên người tạo..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary px-4">🔍 Tìm kiếm</button>
                <a href="{{ route('admin.resumes.index') }}" class="btn btn-outline-secondary ms-2">Làm mới</a>
            </div>
        </form>
    </div>
</div>

{{-- Bảng Danh sách CV --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width:50px">#</th>
                    <th>Thông tin CV</th>
                    <th>Chủ sở hữu</th>
                    <th>Template</th>
                    <th class="text-center">Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resumes as $resume)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="fw-semibold text-dark">{{ Str::limit($resume->title, 40) }}</div>
                        <div class="text-muted small">{{ $resume->job_title ?? 'Chưa cập nhật vị trí' }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width:30px;height:30px;font-size:12px;">
                                {{ strtoupper(substr(optional($resume->users)->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-dark fw-medium" style="font-size: 14px;">{{ optional($resume->users)->name ?? 'User đã bị xoá' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ optional($resume->templates)->name ?? 'Mặc định' }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($resume->is_public)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">Công khai</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">Riêng tư</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $resume->created_at->format('d/m/Y') }}</td>
                    <td class="text-end pe-4">
                        @if($resume->is_public)
                            <a href="/cv/public/{{ $resume->slug }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="Xem public">
                                👁️ Xem
                            </a>
                        @endif
                        <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteResume({{ $resume->id }})">
                            🗑 Xoá
                        </button>
                        <form id="delete-resume-{{ $resume->id }}" action="{{ route('admin.resumes.destroy', $resume->id) }}" method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <div class="fs-1 mb-2">📋</div>
                        Hệ thống chưa có hồ sơ CV nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($resumes) && $resumes->hasPages())
    <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
        {{ $resumes->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmDeleteResume(id) {
    if (confirm('⚠️ Bạn chắc chắn muốn xoá vĩnh viễn hồ sơ CV này khỏi hệ thống?')) {
        document.getElementById('delete-resume-' + id).submit();
    }
}
</script>
@endpush