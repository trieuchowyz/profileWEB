@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-bold">Tổng quan hệ thống</h3>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold mb-2 opacity-75">Tổng User</h6>
                        <h2 class="mb-0 fw-bold">1,245</h2>
                    </div>
                    <i class="fa-solid fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold mb-2 opacity-75">CV Đã Tạo</h6>
                        <h2 class="mb-0 fw-bold">8,432</h2>
                    </div>
                    <i class="fa-solid fa-file-invoice fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-semibold mb-2 opacity-75">Template Khả dụng</h6>
                        <h2 class="mb-0 fw-bold">24</h2>
                    </div>
                    <i class="fa-solid fa-swatchbook fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <h5 class="fw-bold mb-4">Người dùng đăng ký mới (Tháng này)</h5>
                <canvas id="userChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
                datasets: [{
                    label: 'User mới',
                    data: [120, 190, 150, 220],
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4 // Làm cong đường line
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endpush