@extends('layouts.client')

@section('title', 'Chính sách bảo mật - CV Pro')

@push('styles')
<style>
  .page-wrapper {
    padding: 60px 20px;
    background-color: var(--pink-50);
    min-height: calc(100vh - 120px);
  }
  .content-card {
    max-width: 860px;
    margin: 0 auto;
    background: #fff;
    padding: 48px;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-card);
  }
  .page-title {
    font-size: 32px;
    color: var(--pink-900);
    margin-bottom: 8px;
    text-align: center;
    font-weight: 700;
  }
  .page-subtitle {
    text-align: center;
    color: var(--gray-600);
    margin-bottom: 40px;
    font-size: 15px;
  }
  .content-body h3 {
    color: var(--pink-700);
    margin-top: 32px;
    margin-bottom: 16px;
    font-size: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .content-body p, .content-body li {
    color: var(--gray-600);
    line-height: 1.7;
    margin-bottom: 12px;
    font-size: 15px;
  }
  .content-body ul {
    padding-left: 24px;
    margin-bottom: 20px;
  }
  @media (max-width: 768px) {
    .content-card { padding: 32px 24px; }
    .page-title { font-size: 26px; }
  }
</style>
@endpush

@section('content')
<div class="page-wrapper">
  <div class="content-card">
    <h1 class="page-title">Chính Sách Bảo Mật</h1>
    <p class="page-subtitle">Cập nhật lần cuối: {{ date('d/m/Y') }}</p>

    <div class="content-body">
      <p>Chào mừng bạn đến với CV Pro. Chúng tôi cam kết bảo vệ thông tin cá nhân và quyền riêng tư của bạn. Chính sách này giải thích cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu của bạn khi sử dụng nền tảng tạo CV của chúng tôi.</p>

      <h3><i class="ti ti-database"></i> 1. Thu thập thông tin</h3>
      <p>Khi bạn đăng ký và sử dụng CV Pro, chúng tôi có thể thu thập các thông tin sau:</p>
      <ul>
        <li><strong>Thông tin tài khoản:</strong> Họ tên, địa chỉ email, mật khẩu (được mã hóa).</li>
        <li><strong>Dữ liệu Hồ sơ (CV):</strong> Kinh nghiệm làm việc, học vấn, kỹ năng, số điện thoại, địa chỉ và các thông tin khác bạn chủ động nhập vào form tạo CV.</li>
        <li><strong>Dữ liệu hệ thống:</strong> Lịch sử truy cập, địa chỉ IP, cookie để cải thiện trải nghiệm người dùng.</li>
      </ul>

      <h3><i class="ti ti-settings"></i> 2. Mục đích sử dụng thông tin</h3>
      <p>Chúng tôi sử dụng thông tin của bạn vào các mục đích:</p>
      <ul>
        <li>Khởi tạo, lưu trữ và xuất bản các mẫu CV theo yêu cầu của bạn.</li>
        <li>Xác thực tài khoản và hỗ trợ khôi phục mật khẩu.</li>
        <li>Cải thiện chất lượng dịch vụ và nâng cấp các mẫu CV (Templates) mới.</li>
      </ul>

      <h3><i class="ti ti-shield-lock"></i> 3. Bảo vệ dữ liệu</h3>
      <p>CV Pro áp dụng các biện pháp bảo mật kỹ thuật hiện đại để chống lại việc truy cập, thay đổi hoặc đánh cắp dữ liệu trái phép. Mật khẩu của bạn được mã hóa một chiều an toàn bằng chuẩn của framework Laravel.</p>
      <p>Chúng tôi <strong>không bao giờ bán, cho thuê hoặc chia sẻ</strong> thông tin cá nhân hay nội dung CV của bạn cho bên thứ ba vì mục đích tiếp thị mà không có sự đồng ý rõ ràng từ bạn.</p>

      <h3><i class="ti ti-user-check"></i> 4. Quyền của người dùng</h3>
      <p>Bạn có toàn quyền truy cập, chỉnh sửa hoặc xóa vĩnh viễn các hồ sơ CV và tài khoản của mình khỏi hệ thống CV Pro bất cứ lúc nào thông qua trang Quản lý tài khoản.</p>

      <h3><i class="ti ti-headset"></i> 5. Liên hệ với chúng tôi</h3>
      <p>Nếu bạn có bất kỳ thắc mắc nào về Chính sách bảo mật này, vui lòng liên hệ trực tiếp với đội ngũ phát triển qua email: <strong>nguyenvantrieu1872006@gmail.com</strong> hoặc <strong>thinh.truong@cvpro.vn</strong>.</p>
    </div>
  </div>
</div>
@endsection
