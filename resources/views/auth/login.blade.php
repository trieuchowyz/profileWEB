@extends('layouts.login-register')

@section('title', 'Đăng nhập - CV Pro')

@section('content')
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
