<header class="header">
  
  <div class="header-left" style="display: flex; align-items: center; gap: 20px;">
    <a href="/" class="logo" style="text-decoration: none;">
      <div class="logo-icon">
        <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <polygon points="7,1 13,4.5 13,10.5 7,14 1,10.5 1,4.5" fill="#fff"/>
          <polygon points="7,4 10.5,6 10.5,10 7,12 3.5,10 3.5,6" fill="rgba(255,255,255,0.4)"/>
        </svg>
      </div>
      <span>CV Pro</span>
    </a>

    <div class="search-bar">
      <i class="ti ti-search" aria-hidden="true"></i>
      <input type="text" placeholder="Tìm CV, tìm việc...">
    </div>
  </div>

  <nav class="nav">
    <a href="/" class="nav-link active">Home</a>
    <a href="#" class="nav-link">Mẫu CV</a>
    <a href="#" class="nav-link">CV tham khảo</a>
  </nav>

  <div class="header-right">
    <button class="btn-primary" id="btnCreateHeader" style="padding: 8px 16px; border-radius: 6px; border: none; background-color: #3b82f6; color: white; cursor: pointer; font-weight: 500;">
      Tạo CV
    </button>
    <span class="flag-icon" title="Tiếng Việt" style="cursor: pointer;">🇻🇳</span>
    <a href="{{ route('login') }}" class="login-link" style="text-decoration: none; color: #333; font-weight: 500;">Đăng nhập</a>
  </div>

</header>