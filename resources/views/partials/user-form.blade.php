{{-- Dùng chung cho Create & Edit --}}
<div class="row g-3">
    <div class="col-12">
        <label class="form-label fw-semibold">Họ tên <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $user->name ?? '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $user->email ?? '') }}" required>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">
            Mật khẩu {{ $user ? '<small class="text-muted">(để trống nếu không đổi)</small>' : '<span class="text-danger">*</span>' }}
        </label>
        <input type="password" name="password" class="form-control"
               {{ $user ? '' : 'required' }}
               placeholder="{{ $user ? 'Nhập mật khẩu mới nếu muốn đổi' : 'Tối thiểu 8 ký tự' }}">
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation" class="form-control"
               placeholder="Nhập lại mật khẩu">
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Vai trò <span class="text-danger">*</span></label>
        <select name="role" class="form-select" required>
            <option value="user"  {{ old('role', $user->role ?? 'user') === 'user'  ? 'selected' : '' }}>User</option>
            <option value="admin" {{ old('role', $user->role ?? '')     === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Avatar</label>
        <input type="file" name="avatar" class="form-control" accept="image/*">
        @if(!empty($user->avatar))
            <div class="mt-2 d-flex align-items-center gap-2">
                <img src="{{ Storage::url($user->avatar) }}"
                     alt="Avatar" class="rounded-circle" style="width:40px;height:40px;object-fit:cover">
                <small class="text-muted">Avatar hiện tại</small>
            </div>
        @endif
    </div>
</div>