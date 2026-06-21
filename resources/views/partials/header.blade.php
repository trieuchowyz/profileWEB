<style>
  .user-dropdown-wrap { position: relative; cursor: pointer; height: 100%; display: flex; align-items: center; }

  .dropdown-menu {
    position: absolute; top: 100%; right: 0;
    background: #fff; box-shadow: 0 10px 25px rgba(139, 58, 90, 0.1);
    border-radius: var(--radius-md); width: 230px; padding: 8px 0;
    margin-top: 10px; opacity: 0; visibility: hidden;
    transform: translateY(10px); transition: all 0.2s ease;
    z-index: 100; border: 1px solid var(--pink-100);
  }

  /* Hiển thị menu khi hover vào avatar */
  .user-dropdown-wrap:hover .dropdown-menu {
    opacity: 1; visibility: visible; transform: translateY(0);
  }

  .dropdown-item {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 20px; color: var(--gray-600);
    text-decoration: none; font-size: 13.5px; font-weight: 500;
    transition: background 0.2s, color 0.2s;
  }

  .dropdown-item:hover { background: var(--pink-50); color: var(--pink-600); }

  .dropdown-item.logout { color: #e11d48; width: 100%; border: none; background: transparent; text-align: left; cursor: pointer; }
  .dropdown-item.logout:hover { background: #ffe4e6; }
</style>

<header class="header">
  <div class="header-left" style="display: flex; align-items: center; gap: 20px;">
    <a href="{{ route('home') }}" class="logo" style="text-decoration: none;">
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
    <a href="{{ route('home') }}" class="nav-link active">Home</a>
    <a href="#" class="nav-link">Mẫu CV</a>
    <a href="#" class="nav-link">CV tham khảo</a>
  </nav>

  <div class="header-right" style="display: flex; align-items: center; gap: 16px;">
    <button class="btn-primary" id="btnCreateHeader" style="padding: 8px 16px; border-radius: 6px; border: none; background-color: var(--pink-600); color: white; cursor: pointer; font-weight: 500;">
      Tạo CV
    </button>
    <span class="flag-icon" title="Tiếng Việt" style="cursor: pointer;">🇻🇳</span>
    
    <!-- NẾU CHƯA ĐĂNG NHẬP (GUEST) -->
    @guest
        <a href="{{ route('login') }}" class="login-link" style="text-decoration: none; color: var(--pink-600); font-weight: 600;">Đăng nhập</a>
        <a href="{{ route('register') }}" style="text-decoration: none; background: #f3f4f6; color: #333; padding: 6px 12px; border-radius: 6px; font-weight: 500;">Đăng ký</a>
    @endguest

    <!-- NẾU ĐÃ ĐĂNG NHẬP (AUTH) -->
    @auth
      <div class="user-dropdown-wrap">
        <!-- Avatar & Tên User -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--pink-100); color: var(--pink-700); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px;">
            <!-- Lấy chữ cái đầu tiên trong tên User -->
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
          <span style="font-size: 14px; font-weight: 600; color: var(--pink-900);">{{ Auth::user()->name }}</span>
          <i class="ti ti-chevron-down" style="font-size: 14px; color: var(--gray-600);"></i>
        </div>

        <!-- Menu Dropdown -->
        <div class="dropdown-menu">
          <!-- Vào trang thông tin cá nhân -->
          <a href="{{ route('profile.show') }}" class="dropdown-item">
            <i class="ti ti-user" style="font-size: 18px;"></i> Hồ sơ cá nhân
          </a>
          <!-- Vào trang quản lý CV -->
          <a href="{{ route('profile.cvs') }}" class="dropdown-item">
            <i class="ti ti-file-text" style="font-size: 18px;"></i> Quản lý CV của tôi
          </a>

          <hr style="border: none; border-top: 1px solid var(--pink-100); margin: 6px 0;">

          <!-- Form Đăng xuất -->
          <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="dropdown-item logout">
              <i class="ti ti-logout" style="font-size: 18px;"></i> Đăng xuất
            </button>
          </form>
        </div>
      </div>
    @endauth
  </div>
</header>