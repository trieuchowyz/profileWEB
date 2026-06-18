<footer class="footer">
    <div class="footer-container">
        <div class="footer-top">

            <div class="footer-brand">
                <a href="/" class="logo" style="text-decoration: none;">
                    <div class="logo-icon">
                        <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <polygon points="7,1 13,4.5 13,10.5 7,14 1,10.5 1,4.5" fill="#fff" />
                            <polygon points="7,4 10.5,6 10.5,10 7,12 3.5,10 3.5,6" fill="rgba(255,255,255,0.4)" />
                        </svg>
                    </div>
                    <span>CV Pro</span>
                </a>

                <p class="footer-desc" style="margin-bottom: 12px;">
                    Nền tảng tạo CV chuẩn ATS hàng đầu, ứng dụng công nghệ thông minh giúp bạn tối ưu hóa từ khóa, dễ
                    dàng vượt qua vòng lọc hồ sơ khắt khe nhất. Chúng tôi đồng hành cùng bạn chinh phục mọi nhà tuyển
                    dụng và kiến tạo con đường sự nghiệp vượt trội.
                </p>

                <div
                    style="font-size: 13.5px; color: var(--gray-600); margin-bottom: 24px; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5;">
                    <i class="ti ti-map-pin" style="color: var(--pink-600); font-size: 18px; margin-top: 2px;"></i>
                    <span><strong>Trụ sở chính:</strong> Khu Công nghệ cao, TP. Thủ Đức, TP. Hồ Chí Minh, Việt
                        Nam</span>
                </div>

                <div class="footer-socials">
                    <a href="#" style="width: 44px; height: 44px; font-size: 22px;"><i
                            class="ti ti-brand-facebook"></i></a>
                    <a href="#" style="width: 44px; height: 44px; font-size: 22px;"><i
                            class="ti ti-brand-linkedin"></i></a>
                    <a href="#" style="width: 44px; height: 44px; font-size: 22px;"><i
                            class="ti ti-brand-youtube"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <div class="link-group">
                    <h4>Khám phá</h4>
                    <a href="/">Mẫu CV Chuyên Nghiệp</a>
                    <a href="/">CV Tham khảo</a>
                    <h4>Hỗ trợ</h4>
                    <a href="{{ route('client.privacy') }}">Chính sách bảo mật</a>
                    <a href="{{ route('client.terms') }}">Điều khoản sử dụng</a>
                </div>

                <div class="link-group">
                    <h4>Liên hệ & Đội ngũ</h4>
                    <span style="display:block; font-size: 13.5px; color: var(--gray-600); margin-bottom: 6px;">
                        <strong>Dev:</strong> Nguyễn Văn Triều
                    </span>
                    <a href="tel:0987212437" style="display: flex; align-items: center; gap: 6px;">
                        <i class="ti ti-phone"></i> Hotline: 0987212437
                    </a>
                    <a href="https://zalo.me/0987212437" target="_blank"
                        style="display: flex; align-items: center; gap: 6px;">
                        <i class="ti ti-message-circle"></i> Zalo Support
                    </a>
                    <a href="mailto:nguyenvantrieu1872006@gmail.com" target="_blank"
                        style="display: flex; align-items: center; gap: 6px;">
                        <i class="ti ti-brand-google"></i> Google (Email)
                    </a>
                    <span style="display:block; font-size: 13.5px; color: var(--gray-600); margin-bottom: 16px;">
                        <strong>Dev:</strong> Trương Nguyễn Đức Thịnh
                    </span>
                    <a href="tel:0909123456" style="display: flex; align-items: center; gap: 6px;">
                        <i class="ti ti-phone"></i> Hotline: 0909 123 456
                    </a>
                    <a href="https://zalo.me/0909123456" target="_blank"
                        style="display: flex; align-items: center; gap: 6px;">
                        <i class="ti ti-message-circle"></i> Zalo Support
                    </a>
                    <a href="mailto:thinh.truong@cvpro.vn" target="_blank"
                        style="display: flex; align-items: center; gap: 6px;">
                        <i class="ti ti-brand-google"></i> Google (Email)
                    </a>
                </div>

            </div>

        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} CV Pro. Hệ thống quản lý và tạo CV trực tuyến.</p>
        </div>
    </div>
</footer>
