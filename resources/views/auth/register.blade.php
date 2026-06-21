@extends('layouts.client')

@section('title', 'Đăng ký - CV Pro')

@section('content')
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <h1 class="auth-title">Đăng ký</h1>
      <p class="auth-subtitle">Tạo tài khoản mới để bắt đầu thiết kế CV.</p>
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; font-size: 14px; text-align: center; margin-bottom: 20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" id="registerForm">
      @csrf

      <div class="form-group">
        <label for="name" class="form-label">Họ và tên</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Ví dụ: Nguyễn Văn Triều" required value="{{ old('name') }}">
      </div>

      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Ví dụ: user@email.com" required value="{{ old('email') }}">
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Mật khẩu</label>
        <div style="position: relative;">
          <input type="password" id="password" name="password" class="form-control" placeholder="Tối thiểu 8 ký tự" required minlength="8" style="padding-right: 40px;">
          <i class="ti ti-eye toggle-password" data-target="password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--gray-600); font-size: 18px;"></i>
        </div>
      </div>

      <div class="form-group">
        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
        <div style="position: relative;">
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required minlength="8" style="padding-right: 40px;">
          <i class="ti ti-eye toggle-password" data-target="password_confirmation" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--gray-600); font-size: 18px;"></i>
        </div>
      </div>

      <button type="submit" class="btn-submit" id="submitBtnReg">
        <span class="btn-text" id="btnTextReg">Đăng ký tài khoản</span>
        <div class="spinner" id="btnSpinnerReg" style="display: none; margin-left: 8px;"></div>
      </button>
    </form>

    <div class="auth-footer">
      Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
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

    // Xử lý hiệu ứng loading khi bấm Đăng ký
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function() {
            const btn = document.getElementById('submitBtnReg');
            const spinner = document.getElementById('btnSpinnerReg');
            const text = document.getElementById('btnTextReg');
            
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.style.cursor = 'not-allowed';
            if (spinner) spinner.style.display = 'inline-block';
            if (text) text.innerHTML = 'Đang xử lý...';
        });
    }
</script>
@endsection