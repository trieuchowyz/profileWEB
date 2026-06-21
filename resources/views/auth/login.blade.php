<<<<<<< HEAD
@extends('layouts.client')
=======
@extends('layouts.login-register')
>>>>>>> 24a87749c57191d309991196f79958282a21f712

@section('title', 'Đăng nhập - CV Pro')

@section('content')
<<<<<<< HEAD
<div class="auth-container" style="min-height: calc(100vh - 150px); display: flex; align-items: center; justify-content: center; background-color: #f9fafb; padding: 40px 20px;">
    <div class="auth-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 24px; color: #111827;">Đăng nhập</h2>
        
        @if ($errors->any())
            <div style="background: #fee2e2; color: #dc2626; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; color: #4b5563; font-size: 14px; font-weight: 500;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
            </div>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; color: #4b5563; font-size: 14px; font-weight: 500;">Mật khẩu</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" required style="width: 100%; padding: 10px 40px 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
                    <i class="ti ti-eye-off toggle-password" data-target="password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; font-size: 18px;"></i>
                </div>
            </div>

            <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" id="remember" name="remember" style="cursor: pointer; width: 16px; height: 16px;">
                <label for="remember" style="color: #4b5563; font-size: 14px; cursor: pointer; user-select: none;">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" style="width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 15px;">Đăng nhập</button>
        </form>
        <p style="text-align: center; margin-top: 20px; color: #6b7280; font-size: 14px;">
            Chưa có tài khoản? <a href="{{ route('register') }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Đăng ký ngay</a>
        </p>
    </div>
</div>

<script>
    // Script xử lý ẩn hiện mật khẩu
    document.querySelectorAll('.toggle-password').forEach(function(icon) {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('ti-eye-off');
                this.classList.add('ti-eye');
            } else {
                input.type = 'password';
                this.classList.remove('ti-eye');
                this.classList.add('ti-eye-off');
            }
        });
    });
</script>
@endsection
=======
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <h1 class="auth-title">Đăng nhập</h1>
      <p class="auth-subtitle">Chào mừng trở lại! Vui lòng nhập thông tin.</p>
    </div>

    <form id="loginForm">
      @csrf

      <div id="generalError" class="form-group" style="display: none;">
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; font-size: 14px; text-align: center;">
          Thông tin đăng nhập không chính xác.
        </div>
      </div>

      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="ví dụ: user@email.com" required>
        <div class="form-error" id="emailError"></div>
      </div>

      <!-- Đã bọc thêm div relative và icon con mắt -->
      <div class="form-group">
        <label for="password" class="form-label">Mật khẩu</label>
        <div style="position: relative;">
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required style="padding-right: 40px;">
          <i class="ti ti-eye toggle-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--gray-600); font-size: 18px;"></i>
        </div>
        <div class="form-error" id="passwordError"></div>
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
        <div class="spinner" id="btnSpinner"></div>
      </button>
    </form>

    <div class="auth-footer">
      Chưa có tài khoản? <a href="{{ route('auth.register') }}">Đăng ký ngay</a>
    </div>
  </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('client/login-register.js') }}"></script>
@endpush
>>>>>>> 24a87749c57191d309991196f79958282a21f712
