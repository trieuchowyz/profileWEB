@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Quản lý Template CV</h3>
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#templateModal">
            <i class="fa-solid fa-plus me-2"></i>Thêm Template
        </button>
    </div>

    <div class="card p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="templatesTable">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Thumbnail</th>
                        <th>Tên Template</th>
                        <th>View Path</th>
                        <th>Trạng thái</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center py-4">Đang tải dữ liệu...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="templateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white bg-primary">
                <h5 class="modal-title" id="modalTitle">Thêm Template mới</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="templateForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="templateId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên Template</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="VD: Modern Blue">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">View Path</label>
                        <input type="text" class="form-control" id="view_path" name="view_path" required placeholder="VD: cv.templates.modern">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thumbnail (Image)</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    </div>
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked value="1">
                        <label class="form-check-label" for="is_active">Kích hoạt Template</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary" id="btnSave">Lưu Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const API_URL = '/admin/templates'; 
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

    document.addEventListener("DOMContentLoaded", () => {
        loadTemplates();

        // Xử lý submit form (Tạo mới hoặc Cập nhật)
        document.getElementById('templateForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = document.getElementById('templateId').value;
            const url = id ? `${API_URL}/${id}` : API_URL;
            
            // Dùng FormData vì có upload file
            const formData = new FormData(this);
            // Laravel yêu cầu _method = POST để update multipart/form-data theo controller của bạn
            
            try {
                const response = await fetch(url, {
                    method: 'POST', // Controller xử lý update cũng bằng POST
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: formData
                });
                
                if (response.ok) {
                    bootstrap.Modal.getInstance(document.getElementById('templateModal')).hide();
                    this.reset();
                    loadTemplates();
                } else {
                    const data = await response.json();
                    alert('Lỗi: ' + JSON.stringify(data.errors));
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    // Lấy dữ liệu từ API và render bảng
    async function loadTemplates() {
        try {
            const response = await fetch(API_URL);
            const res = await response.json();
            const tbody = document.querySelector('#templatesTable tbody');
            tbody.innerHTML = '';

            if (res.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4">Chưa có template nào.</td></tr>';
                return;
            }

            res.data.forEach(template => {
                const badgeClass = template.is_active ? 'bg-success' : 'bg-secondary';
                const badgeText = template.is_active ? 'Active' : 'Inactive';
                const thumbnailUrl = template.thumbnail ? `/storage/${template.thumbnail}` : 'https://placehold.co/100x140?text=No+Image';

                tbody.innerHTML += `
                    <tr>
                        <td class="ps-4">
                            <img src="${thumbnailUrl}" class="rounded shadow-sm" width="50" height="70" style="object-fit: cover;">
                        </td>
                        <td class="fw-bold">${template.name}</td>
                        <td class="text-muted"><small><code>${template.view_path}</code></small></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    onchange="toggleActive(${template.id}, this.checked)" ${template.is_active ? 'checked' : ''}>
                                <span class="badge ${badgeClass}">${badgeText}</span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-light text-primary me-1" onclick="editTemplate(${template.id})" title="Sửa">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-light text-danger" onclick="deleteTemplate(${template.id})" title="Xóa">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error('Failed to load templates', error);
        }
    }

    // Nút Edit mở Modal và load data
    async function editTemplate(id) {
        try {
            const response = await fetch(`${API_URL}/${id}`);
            const res = await response.json();
            const template = res.data;

            document.getElementById('modalTitle').innerText = 'Sửa Template';
            document.getElementById('templateId').value = template.id;
            document.getElementById('name').value = template.name;
            document.getElementById('view_path').value = template.view_path;
            document.getElementById('is_active').checked = template.is_active;
            
            new bootstrap.Modal(document.getElementById('templateModal')).show();
        } catch (error) {
            console.error('Error fetching template', error);
        }
    }

    // Toggle Active/Inactive theo route toggle-active của Controller
    async function toggleActive(id, isActive) {
        try {
            await fetch(`${API_URL}/${id}/toggle-active`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ is_active: isActive ? 1 : 0 })
            });
            loadTemplates();
        } catch (error) {
            console.error('Toggle error', error);
        }
    }

    // Xóa Template
    async function deleteTemplate(id) {
        if (!confirm('Bạn có chắc chắn muốn xóa template này? Hành động này không thể hoàn tác.')) return;
        
        try {
            const response = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
            });

            if(response.ok) {
                loadTemplates();
            } else {
                const data = await response.json();
                alert(data.message || 'Không thể xóa template này (có thể do đang có CV sử dụng).');
            }
        } catch (error) {
            console.error('Delete error', error);
        }
    }
</script>
@endpush