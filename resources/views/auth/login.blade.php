@extends('layouts.client')

@section('title', 'Đăng nhập - CV Pro')

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <h1 class="auth-title">Đăng nhập</h1>
      <p class="auth-subtitle">Chào mừng trở lại! Vui lòng nhập thông tin.</p>
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; font-size: 14px; text-align: center; margin-bottom: 20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" id="loginForm">
      @csrf

      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="ví dụ: user@email.com" required value="{{ old('email') }}">
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Mật khẩu</label>
        <div style="position: relative;">
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required style="padding-right: 40px;">
          <i class="ti ti-eye toggle-password" data-target="password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--gray-600); font-size: 18px;"></i>
        </div>
      </div>

      <div class="form-options">
        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
          <input type="checkbox" name="remember" id="remember" style="accent-color: var(--pink-600);">
          <span>Ghi nhớ tôi</span>
        </label>
        <a href="#" class="forgot-link">Quên mật khẩu?</a>
      </div>

      <button type="submit" class="btn-submit" id="submitBtn">
        <span class="btn-text">Đăng nhập</span>
        <div class="spinner" id="btnSpinner" style="display: none; margin-left: 8px;"></div>
      </button>
    </form>

    <div class="auth-footer">
      Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
    </div>
  </div>
</div>

<script>
    // Xử lý ẩn hiện mật khẩu
    document.querySelectorAll('.toggle-password').forEach(function(icon) {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('ti-eye');
                this.classList.add('ti-eye-off');
            } else {
                input.type = 'password';
                this.classList.remove('ti-eye-off');
                this.classList.add('ti-eye');
            }
        });
    });

    // Xử lý hiệu ứng loading khi bấm Đăng nhập
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const spinner = document.getElementById('btnSpinner');
            
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'not-allowed';
            if (spinner) spinner.style.display = 'inline-block';
        });
    }
</script>
@endsection