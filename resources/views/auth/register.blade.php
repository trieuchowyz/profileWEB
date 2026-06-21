<<<<<<< HEAD
@extends('layouts.client')
=======
@extends('layouts.login-register')
>>>>>>> 24a87749c57191d309991196f79958282a21f712

@section('title', 'Đăng ký - CV Pro')

@section('content')
<<<<<<< HEAD
<div class="auth-container" style="min-height: calc(100vh - 150px); display: flex; align-items: center; justify-content: center; background-color: #f9fafb; padding: 40px 20px;">
    <div class="auth-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 24px; color: #111827;">Tạo tài khoản mới</h2>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; color: #4b5563; font-size: 14px; font-weight: 500;">Họ và tên</label>
                <input type="text" name="name" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
            </div>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; color: #4b5563; font-size: 14px; font-weight: 500;">Email</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 6px; color: #4b5563; font-size: 14px; font-weight: 500;">Mật khẩu</label>
                <div style="position: relative;">
                    <input type="password" id="reg-password" name="password" required style="width: 100%; padding: 10px 40px 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
                    <i class="ti ti-eye-off toggle-password" data-target="reg-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; font-size: 18px;"></i>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 6px; color: #4b5563; font-size: 14px; font-weight: 500;">Xác nhận mật khẩu</label>
                <div style="position: relative;">
                    <input type="password" id="reg-password-confirm" name="password_confirmation" required style="width: 100%; padding: 10px 40px 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; outline: none; box-sizing: border-box;">
                    <i class="ti ti-eye-off toggle-password" data-target="reg-password-confirm" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6b7280; font-size: 18px;"></i>
                </div>
            </div>

            <button type="submit" style="width: 100%; padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 15px;">Đăng ký</button>
        </form>
        <p style="text-align: center; margin-top: 20px; color: #6b7280; font-size: 14px;">
            Đã có tài khoản? <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;">Đăng nhập</a>
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
      <h1 class="auth-title">Đăng ký</h1>
      <p class="auth-subtitle">Tạo tài khoản mới để bắt đầu thiết kế CV.</p>
    </div>

    <form id="registerForm">
      @csrf

      <div id="generalErrorReg" class="form-group" style="display: none;">
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px 15px; border-radius: 6px; font-size: 13.5px; text-align: center;">
          Có lỗi xảy ra, vui lòng thử lại.
        </div>
      </div>

      <div class="form-group">
        <label for="name" class="form-label">Họ và tên</label>
        <input type="text" id="name" name="name" class="form-control" placeholder="Ví dụ: Nguyễn Văn Triều" required>
        <div class="form-error" id="nameError"></div>
      </div>

      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Ví dụ: user@email.com" required>
        <div class="form-error" id="emailError"></div>
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Mật khẩu</label>
        <div style="position: relative;">
          <input type="password" id="password" name="password" class="form-control" placeholder="Tối thiểu 8 ký tự" required minlength="8" style="padding-right: 40px;">
          <i class="ti ti-eye toggle-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--gray-600); font-size: 18px;"></i>
        </div>
        <div class="form-error" id="passwordError"></div>
      </div>

      <div class="form-group">
        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
        <div style="position: relative;">
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" required minlength="8" style="padding-right: 40px;">
          <i class="ti ti-eye toggle-password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--gray-600); font-size: 18px;"></i>
        </div>
        <div class="form-error" id="password_confirmationError"></div>
      </div>

      <button type="submit" class="btn-submit" id="submitBtnReg">
        <span class="btn-text" id="btnTextReg">Đăng ký tài khoản</span>
        <div class="spinner" id="btnSpinnerReg"></div>
      </button>
    </form>

    <div class="auth-footer">
      Đã có tài khoản? <a href="{{ route('auth.login') }}">Đăng nhập ngay</a>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('client/login-register.js') }}"></script>
@endpush
>>>>>>> 24a87749c57191d309991196f79958282a21f712
