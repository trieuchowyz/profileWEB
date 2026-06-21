@extends('layouts.client')

@section('title', 'CV Pro - Nền tảng Tạo CV Số 1')

@section('content')
<section class="hero">
  <div class="hero-bg-blob blob-1"></div>
  <div class="hero-bg-blob blob-2"></div>
  <div class="hero-bg-dots"></div>

  <div class="hero-left">
    <span class="hero-tag">
      <i class="ti ti-device-laptop" aria-hidden="true"></i>
      Nền tảng tạo CV chuẩn quốc tế hàng đầu trên mọi thiết bị.
    </span>
    <h1 class="hero-heading">
      Định hình sự nghiệp vượt trội từ một bản CV hoàn hảo.
    </h1>
    <p class="hero-desc">
      Xây dựng CV chuyên nghiệp trong vài phút với công nghệ AI, mẫu chuẩn ATS và công cụ kéo-thả trực quan.
    </p>
    <div class="hero-btns">
      <button class="btn-primary" id="btnCreate">
        <i class="ti ti-plus" aria-hidden="true"></i>
        Tạo CV ngay
      </button>
      <button class="btn-outline" id="btnDemo">
        <i class="ti ti-player-play" aria-hidden="true"></i>
        Dùng thử Demo
      </button>
    </div>

    <div class="hero-stats">
      <div class="stat-item">
        <span class="stat-num">50K+</span>
        <span class="stat-label">CV đã tạo</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-item">
        <span class="stat-num">1000+</span>
        <span class="stat-label">Mẫu chuẩn ATS</span>
      </div>
      <div class="stat-divider"></div>
      <div class="stat-item">
        <span class="stat-num">98%</span>
        <span class="stat-label">Hài lòng</span>
      </div>
    </div>
  </div>

  <div class="hero-right">
    <div class="cv-stack">

      <div class="cv-card cv-side-left-top" style="--rotate: -6deg; --z: 3;">
        <div class="cv-mini-header" style="background: linear-gradient(135deg, #5a3070, #9060b0);">
          <div class="cv-mini-avatar" style="background:#d0b0e8; color:#5a3070;">PH</div>
          <div>
            <div class="cv-mini-name">Phạm Hương Giang</div>
            <div class="cv-mini-role">ECS Specialist</div>
          </div>
        </div>
        <div class="cv-mini-body">
          <div class="mini-line" style="width:80%; background:#d8c8e8;"></div>
          <div class="mini-line" style="width:60%; background:#d8c8e8;"></div>
          <div class="mini-line" style="width:90%; background:#d8c8e8;"></div>
          <div class="mini-skills">
            <div class="mini-skill-bar">
              <div class="mini-skill-fill" style="width:78%; background:#7a50a0;"></div>
            </div>
            <div class="mini-skill-bar">
              <div class="mini-skill-fill" style="width:55%; background:#7a50a0;"></div>
            </div>
            <div class="mini-skill-bar">
              <div class="mini-skill-fill" style="width:88%; background:#7a50a0;"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="cv-card cv-side-right-top" style="--rotate: 5deg; --z: 3;">
        <div class="cv-mini-header" style="background: linear-gradient(135deg, #1a6060, #2a9080);">
          <div class="cv-mini-avatar" style="background:#a0e0d8; color:#1a6060;">AQ</div>
          <div>
            <div class="cv-mini-name">Anh Quốc Đạt</div>
            <div class="cv-mini-role">Software Engineer</div>
          </div>
        </div>
        <div class="cv-mini-body">
          <div class="mini-line" style="width:85%; background:#c0e8e0;"></div>
          <div class="mini-line" style="width:70%; background:#c0e8e0;"></div>
          <div class="skill-tags">
            <span class="skill-tag teal">React</span>
            <span class="skill-tag teal">Node.js</span>
            <span class="skill-tag teal">Python</span>
            <span class="skill-tag teal">AWS</span>
          </div>
          <div class="mini-line" style="width:75%; background:#c0e8e0; margin-top:5px;"></div>
        </div>
      </div>

      <div class="cv-card cv-main-card" style="--z: 5;">
        <div class="cv-main-header">
          <div class="cv-main-avatar">PH</div>
          <div class="cv-main-info">
            <div class="cv-main-name">Phạm Hương Giang</div>
            <div class="cv-main-role">Marketing Manager</div>
          </div>
          <div class="cv-main-badge">ATS Ready</div>
        </div>

        <div class="cv-main-body">
          <div class="cv-sidebar">
            <div class="section-label">Liên hệ</div>
            <div class="contact-item">
              <i class="ti ti-mail" aria-hidden="true"></i>
              <span>pham@email.com</span>
            </div>
            <div class="contact-item">
              <i class="ti ti-phone" aria-hidden="true"></i>
              <span>0901 234 567</span>
            </div>
            <div class="contact-item">
              <i class="ti ti-map-pin" aria-hidden="true"></i>
              <span>TP. Hồ Chí Minh</span>
            </div>
            <div class="contact-item">
              <i class="ti ti-brand-linkedin" aria-hidden="true"></i>
              <span>linkedin/phamhuong</span>
            </div>

            <div class="section-label" style="margin-top:10px;">Kỹ năng</div>
            <div class="skill-row">
              <span class="skill-name">Marketing</span>
              <div class="skill-bar-wrap">
                <div class="skill-fill" style="width:90%;"></div>
              </div>
            </div>
            <div class="skill-row">
              <span class="skill-name">SEO / SEM</span>
              <div class="skill-bar-wrap">
                <div class="skill-fill" style="width:75%;"></div>
              </div>
            </div>
            <div class="skill-row">
              <span class="skill-name">Analytics</span>
              <div class="skill-bar-wrap">
                <div class="skill-fill" style="width:85%;"></div>
              </div>
            </div>
            <div class="skill-row">
              <span class="skill-name">Design</span>
              <div class="skill-bar-wrap">
                <div class="skill-fill" style="width:60%;"></div>
              </div>
            </div>
            <div class="skill-row">
              <span class="skill-name">Content</span>
              <div class="skill-bar-wrap">
                <div class="skill-fill" style="width:80%;"></div>
              </div>
            </div>

            <div class="section-label" style="margin-top:10px;">Học vấn</div>
            <div class="edu-block">
              <div class="edu-school">ĐH Kinh tế TP.HCM</div>
              <div class="edu-major">Marketing</div>
              <div class="edu-year">2016 – 2020</div>
            </div>

            <div class="section-label" style="margin-top:10px;">Ngôn ngữ</div>
            <div class="lang-item">Tiếng Việt <span class="lang-level">Bản ngữ</span></div>
            <div class="lang-item">Tiếng Anh <span class="lang-level">IELTS 7.0</span></div>
          </div>

          <div class="cv-content">
            <div class="section-label">Kinh nghiệm làm việc</div>

            <div class="exp-block editable-block" id="editableBlock">
              <div class="editable-tag">
                <i class="ti ti-pencil" aria-hidden="true"></i> editable
              </div>
              <div class="exp-title">Marketing Manager · VinGroup</div>
              <div class="exp-period">
                <i class="ti ti-calendar" aria-hidden="true"></i> 2022 – Hiện tại · TP.HCM
              </div>
              <div class="exp-line" style="width:95%;"></div>
              <div class="exp-line" style="width:80%;"></div>
              <div class="exp-line" style="width:88%;"></div>
              <div class="mouse-cursor" aria-hidden="true">
                <svg viewBox="0 0 16 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 1L15 9.5L8.5 11.5L11 23L7 14L1 23V1Z" fill="#4a1a30" stroke="white" stroke-width="1" />
                </svg>
              </div>
            </div>

            <div class="exp-block">
              <div class="exp-title">Senior Marketing · FPT Corporation</div>
              <div class="exp-period">
                <i class="ti ti-calendar" aria-hidden="true"></i> 2020 – 2022 · TP.HCM
              </div>
              <div class="exp-line" style="width:90%;"></div>
              <div class="exp-line" style="width:75%;"></div>
              <div class="exp-line" style="width:83%;"></div>
            </div>

            <div class="exp-block">
              <div class="exp-title">Marketing Executive · Vinamilk</div>
              <div class="exp-period">
                <i class="ti ti-calendar" aria-hidden="true"></i> 2018 – 2020 · TP.HCM
              </div>
              <div class="exp-line" style="width:85%;"></div>
              <div class="exp-line" style="width:70%;"></div>
            </div>

            <div class="section-label" style="margin-top:8px;">Thành tích nổi bật</div>
            <div class="achievements">
              <span class="achievement-badge">🏆 Top 10 Marketer 2023</span>
              <span class="achievement-badge">📈 Revenue +45%</span>
              <span class="achievement-badge">⭐ Best Campaign 2022</span>
              <span class="achievement-badge">🌐 IELTS 7.0</span>
            </div>
          </div>
        </div>
      </div>

      <div class="cv-card cv-side-left-bot" style="--rotate: -4deg; --z: 4;">
        <div class="cv-mini-header" style="background: linear-gradient(135deg, #7a4010, #c07030);">
          <div class="cv-mini-avatar" style="background:#f0c890; color:#7a4010;">TN</div>
          <div>
            <div class="cv-mini-name">Trần Ngọc Lan</div>
            <div class="cv-mini-role">UI/UX Designer</div>
          </div>
        </div>
        <div class="cv-mini-body">
          <div class="mini-line" style="width:85%; background:#e8d0b0;"></div>
          <div class="mini-line" style="width:65%; background:#e8d0b0;"></div>
          <div class="mini-line" style="width:75%; background:#e8d0b0;"></div>
          <div class="mini-skills">
            <div class="mini-skill-bar">
              <div class="mini-skill-fill" style="width:92%; background:#c07030;"></div>
            </div>
            <div class="mini-skill-bar">
              <div class="mini-skill-fill" style="width:70%; background:#c07030;"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="cv-card cv-side-right-bot" style="--rotate: 4deg; --z: 4;">
        <div class="cv-mini-header" style="background: linear-gradient(135deg, #2a1870, #5040c0);">
          <div class="cv-mini-avatar" style="background:#c0b8f0; color:#2a1870;">TP</div>
          <div>
            <div class="cv-mini-name">Technical Portfolio</div>
            <div class="cv-mini-role">Full Stack Dev</div>
          </div>
        </div>
        <div class="cv-mini-body">
          <div class="skill-tags" style="margin-bottom:5px;">
            <span class="skill-tag purple">Python</span>
            <span class="skill-tag purple">TypeScript</span>
            <span class="skill-tag purple">Docker</span>
            <span class="skill-tag purple">K8s</span>
          </div>
          <div class="mini-line" style="width:80%; background:#c8c0f0;"></div>
          <div class="mini-line" style="width:60%; background:#c8c0f0;"></div>
          <div class="mini-line" style="width:70%; background:#c8c0f0;"></div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="features-bar">
  <div class="feature-item">
    <div class="feature-icon-wrap">
      <i class="ti ti-file-text" aria-hidden="true"></i>
    </div>
    <span class="feature-text">Hơn 1000 mẫu chuẩn ATS</span>
  </div>
  <div class="feat-divider"></div>
  <div class="feature-item">
    <div class="feature-icon-wrap">
      <i class="ti ti-cpu" aria-hidden="true"></i>
    </div>
    <span class="feature-text">Tích hợp gợi ý từ khóa AI</span>
  </div>
  <div class="feat-divider"></div>
  <div class="feature-item">
    <div class="feature-icon-wrap">
      <i class="ti ti-file-export" aria-hidden="true"></i>
    </div>
    <span class="feature-text">Xuất bản PDF, Word, HTML</span>
  </div>
  <div class="feat-divider"></div>
  <div class="feature-item">
    <div class="feature-icon-wrap">
      <i class="ti ti-chart-bar" aria-hidden="true"></i>
    </div>
    <span class="feature-text">Theo dõi lượt xem &amp; phân tích CV</span>
  </div>
  <div class="feat-divider"></div>
  <div class="feature-item">
    <div class="feature-icon-wrap">
      <i class="ti ti-users" aria-hidden="true"></i>
    </div>
    <span class="feature-text">Cộng đồng &amp; Mẹo nghề nghiệp</span>
  </div>
</section>
<section class="templates-showcase">
  <div class="showcase-header">
    <h2>Mẫu CV tham khảo</h2>
    <p>Chọn ngay mẫu CV tuyệt đẹp và ấn tượng bên dưới để dễ dàng thu hút nhà tuyển dụng!</p>
  </div>

  <div class="template-filters">
    <a href="#" class="filter-item active">Toàn bộ ({{ count($templates) }})</a>
    <a href="#" class="filter-item">Colorful</a>
    <a href="#" class="filter-item">Simple</a>
    <a href="#" class="filter-item">Fresher</a>
    <a href="#" class="filter-item">IT Developer</a>
  </div>

  <div class="template-grid">
    @forelse($templates as $template)
    <div class="template-card">
      <div class="template-img-wrap">
        <img src="{{ asset('storage/' . $template->thumbnail) }}" 
     alt="{{ $template->name }}"
     style="width: 100%; height: 100%; object-fit: cover;"
     onerror="this.src='https://placehold.co/400x566/e2e8f0/475569?text=Hinh+CV'">

        <div class="template-overlay">
          <button class="btn-use-template">Tạo CV</button>
        </div>
      </div>

      <div class="template-info">
        <h3 class="template-name">{{ $template->name }}</h3>
        <div class="template-stats">
          <span class="stat"><i class="ti ti-users" aria-hidden="true"></i> {{ rand(1000, 5000) }}</span>
          <span class="stat"><i class="ti ti-thumb-up" aria-hidden="true"></i> {{ rand(50, 200) }}</span>
        </div>
      </div>
    </div>
    @empty
    <p class="templates-empty">Hiện tại chưa có mẫu CV nào trong hệ thống.</p>
    @endforelse
  </div>
</section>

<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <button class="modal-close" id="modalClose"><i class="ti ti-x"></i></button>
    <div class="modal-icon"><i class="ti ti-file-plus"></i></div>
    <h2 class="modal-title">Bắt đầu tạo CV của bạn</h2>
    <p class="modal-desc">Chọn phương thức khởi đầu phù hợp với bạn</p>
    <div class="modal-options">
      <button class="modal-option">
        <i class="ti ti-template" aria-hidden="true"></i>
        <span>Chọn mẫu có sẵn</span>
      </button>
      <button class="modal-option">
        <i class="ti ti-wand" aria-hidden="true"></i>
        <span>Tạo bằng AI</span>
      </button>
      <button class="modal-option">
        <i class="ti ti-upload" aria-hidden="true"></i>
        <span>Import từ LinkedIn</span>
      </button>
    </div>
  </div>
</div>
@endsection