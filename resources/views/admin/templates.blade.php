@extends('layouts.admin')

@section('title', 'Quản lý Templates')
@section('page_title', 'Templates')
@section('page_subtitle', 'Quản lý giao diện CV · CV Builder Admin')

@section('actions')
<button class="btn btn-primary btn-sm d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modalCreate">
    <span>＋</span> Thêm Template
</button>
@endsection

@section('content')

{{-- Alert --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Stats row --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="stat-label text-muted small fw-semibold text-uppercase">Tổng Templates</div>
            <div class="stat-value fs-2 fw-bold text-dark">{{ $templates->total() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="stat-label text-muted small fw-semibold text-uppercase">Đang hoạt động</div>
            <div class="stat-value fs-2 fw-bold text-success">{{ $templates->where('is_active', true)->count() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card p-3 bg-white border-0 shadow-sm rounded">
            <div class="stat-label text-muted small fw-semibold text-uppercase">Tạm ẩn</div>
            <div class="stat-value fs-2 fw-bold text-danger">{{ $templates->where('is_active', false)->count() }}</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4" style="width:60px">#</th>
                    <th style="width:90px">Thumbnail</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>View Path</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-end pe-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $tpl)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        @if($tpl->thumbnail)
                        <img src="{{ Storage::url($tpl->thumbnail) }}"
                            alt="{{ $tpl->name }}"
                            class="rounded border" style="width:64px;height:44px;object-fit:cover;">
                        @else
                        <div class="rounded border bg-light d-flex align-items-center justify-content-center shadow-sm"
                            style="width:64px;height:44px;font-size:20px">🎨</div>
                        @endif
                    </td>
                    <td class="fw-semibold text-dark">{{ $tpl->name }}</td>
                    <td><code class="text-muted bg-light px-2 py-1 rounded">{{ $tpl->slug }}</code></td>
                    <td><code class="text-muted small bg-light px-2 py-1 rounded">{{ $tpl->view_path }}</code></td>
                    <td class="text-center">
                        <div class="form-check form-switch d-inline-flex justify-content-center"
                            style="padding-left:0">
                            <input class="form-check-input toggle-active ms-0"
                                type="checkbox"
                                data-id="{{ $tpl->id }}"
                                style="cursor:pointer"
                                {{ $tpl->is_active ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-outline-primary me-1"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $tpl->id }}">
                            ✏️ Sửa
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $tpl->id }})">
                            🗑 Xoá
                        </button>
                        <form id="delete-form-{{ $tpl->id }}"
                            action="{{ route('admin.templates.destroy', $tpl) }}"
                            method="POST" class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="modalEdit{{ $tpl->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow">
                            <form action="{{ route('admin.templates.update', $tpl) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold text-dark">Sửa Template</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-start">
                                    {{-- FORM BỘ CỤC SỬA --}}
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">Tên Template *</label>
                                            <input type="text" name="name" class="form-control" value="{{ $tpl->name }}" required placeholder="Ví dụ: Modern CV">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">View Path *</label>
                                            <input type="text" name="view_path" class="form-control" value="{{ $tpl->view_path }}" required placeholder="Ví dụ: cv.modern">
                                            <small class="text-muted" style="font-size: 11px;">Đường dẫn file blade (VD: resources/views/cv/modern.blade.php)</small>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label text-muted small fw-semibold">Default Styles (JSON)</label>
                                            <textarea name="default_styles" class="form-control font-monospace text-muted" rows="3" placeholder='{"primary_color":"#3b82f6", "font_family":"Inter"}'>{{ $tpl->default_styles ? json_encode($tpl->default_styles) : '' }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small fw-semibold">Ảnh Thumbnail</label>
                                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                            @if($tpl->thumbnail)
                                                <div class="mt-2 text-muted small">Ảnh hiện tại: <img src="{{ Storage::url($tpl->thumbnail) }}" height="30" class="rounded ms-2 border"></div>
                                            @endif
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center mt-4">
                                            <div class="form-check form-switch mt-3">
                                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active_{{ $tpl->id }}" {{ $tpl->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark ms-2" for="active_{{ $tpl->id }}">Kích hoạt Template này</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- HẾT FORM --}}
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Huỷ</button>
                                    <button type="submit" class="btn btn-primary px-4">Lưu thay đổi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <div class="fs-1 mb-2">🎨</div>
                        Chưa có template nào. <a href="#" data-bs-toggle="modal" data-bs-target="#modalCreate" class="text-primary fw-semibold">Thêm ngay</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($templates->hasPages())
    <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
        {{ $templates->links() }}
    </div>
    @endif
</div>

{{-- Modal Create --}}
<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.templates.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark">Thêm Template mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-start">
                     {{-- FORM BỘ CỤC THÊM MỚI --}}
                     <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Tên Template *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ví dụ: Modern CV">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">View Path *</label>
                            <input type="text" name="view_path" class="form-control" required placeholder="Ví dụ: cv.modern">
                            <small class="text-muted" style="font-size: 11px;">Đường dẫn file blade (VD: resources/views/cv/modern.blade.php)</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label text-muted small fw-semibold">Default Styles (JSON)</label>
                            <textarea name="default_styles" class="form-control font-monospace text-muted" rows="3" placeholder='{"primary_color":"#3b82f6", "font_family":"Inter"}'></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-semibold">Ảnh Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 d-flex align-items-center mt-4">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active_new" checked>
                                <label class="form-check-label text-dark ms-2" for="active_new">Kích hoạt Template này</label>
                            </div>
                        </div>
                    </div>
                    {{-- HẾT FORM --}}
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary px-4">Tạo Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function confirmDelete(id) {
        if (confirm('⚠️ Bạn chắc chắn muốn xoá template này? Các CV đang dùng template này có thể bị lỗi hiển thị!')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    document.querySelectorAll('.toggle-active').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            fetch(`/admin/templates/${id}/toggle`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        this.checked = !this.checked; // rollback nếu lỗi
                        alert('Có lỗi xảy ra khi cập nhật trạng thái.');
                    }
                })
                .catch(() => {
                    this.checked = !this.checked;
                    alert('Không thể kết nối đến máy chủ.');
                });
        });
    });
</script>
@endpush