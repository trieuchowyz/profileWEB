@extends('layouts.client')

@section('title', 'Điều khoản sử dụng - CV Pro')

@push('styles')
<style>
  /* Kế thừa nguyên vẹn CSS từ trang Privacy để đồng bộ giao diện */
  .page-wrapper { padding: 60px 20px; background-color: var(--pink-50); min-height: calc(100vh - 120px); }
  .content-card { max-width: 860px; margin: 0 auto; background: #fff; padding: 48px; border-radius: var(--radius-xl); box-shadow: var(--shadow-card); }
  .page-title { font-size: 32px; color: var(--pink-900); margin-bottom: 8px; text-align: center; font-weight: 700; }
  .page-subtitle { text-align: center; color: var(--gray-600); margin-bottom: 40px; font-size: 15px; }
  .content-body h3 { color: var(--pink-700); margin-top: 32px; margin-bottom: 16px; font-size: 20px; display: flex; align-items: center; gap: 8px; }
  .content-body p, .content-body li { color: var(--gray-600); line-height: 1.7; margin-bottom: 12px; font-size: 15px; }
  .content-body ul { padding-left: 24px; margin-bottom: 20px; }
  @media (max-width: 768px) { .content-card { padding: 32px 24px; } .page-title { font-size: 26px; } }
</style>
@endpush

@section('content')
<div class="page-wrapper">
  <div class="content-card">
    <h1 class="page-title">Điều Khoản Sử Dụng</h1>
    <p class="page-subtitle">Cập nhật lần cuối: {{ date('d/m/Y') }}</p>

    <div class="content-body">
      <p>Bằng việc truy cập và sử dụng nền tảng CV Pro, bạn đồng ý tuân thủ các điều khoản và điều kiện dưới đây. Vui lòng đọc kỹ trước khi sử dụng dịch vụ.</p>

      <h3><i class="ti ti-check"></i> 1. Chấp nhận điều khoản</h3>
      <p>Khi đăng ký tài khoản và tạo hồ sơ trên CV Pro, bạn xác nhận rằng bạn đã đủ 18 tuổi hoặc có sự giám hộ hợp pháp, đồng thời chấp nhận mọi quy định được nêu trong bản Điều khoản này.</p>

      <h3><i class="ti ti-alert-circle"></i> 2. Trách nhiệm của người dùng</h3>
      <ul>
        <li><strong>Tính chính xác:</strong> Bạn chịu hoàn toàn trách nhiệm về tính trung thực và chính xác của các thông tin (kinh nghiệm, học vấn, kỹ năng) được điền vào CV.</li>
        <li><strong>Nội dung hợp pháp:</strong> Bạn không được phép sử dụng CV Pro để tạo ra các nội dung vi phạm pháp luật, đồi trụy, xuyên tạc hoặc vi phạm quyền sở hữu trí tuệ của người khác.</li>
        <li><strong>Bảo mật tài khoản:</strong> Bạn có trách nhiệm bảo vệ mật khẩu của mình. CV Pro không chịu trách nhiệm cho các rủi ro phát sinh do bạn làm lộ thông tin đăng nhập.</li>
      </ul>

      <h3><i class="ti ti-copyright"></i> 3. Quyền sở hữu trí tuệ</h3>
      <p>Dữ liệu cá nhân do bạn nhập vào hoàn toàn thuộc quyền sở hữu của bạn. Tuy nhiên, toàn bộ mã nguồn, thiết kế giao diện (Templates), logo và hệ thống của nền tảng đều thuộc bản quyền tài sản trí tuệ của đội ngũ CV Pro.</p>

      <h3><i class="ti ti-ban"></i> 4. Chấm dứt dịch vụ</h3>
      <p>Chúng tôi có quyền tạm khóa hoặc xóa vĩnh viễn tài khoản của bạn mà không cần báo trước nếu phát hiện có hành vi gian lận, phá hoại hệ thống hoặc vi phạm nghiêm trọng các điều khoản sử dụng này.</p>

      <h3><i class="ti ti-refresh"></i> 5. Sửa đổi điều khoản</h3>
      <p>CV Pro có toàn quyền cập nhật hoặc thay đổi Điều khoản sử dụng bất cứ lúc nào. Mọi thay đổi sẽ có hiệu lực ngay khi được đăng tải trên trang web này.</p>
    </div>
  </div>
</div>
@endsection
