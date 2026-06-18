@extends('layouts.login-register')

@section('title', 'Đăng ký - CV Pro')

@section('content')
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
