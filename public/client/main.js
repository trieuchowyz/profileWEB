/* ====================================
   CV PRO — MAIN JAVASCRIPT
   ==================================== */

(function () {
  'use strict';

  /* ---- Modal ---- */
  const overlay     = document.getElementById('modalOverlay');
  const btnCreate   = document.getElementById('btnCreate');
  const btnHeader   = document.getElementById('btnCreateHeader');
  const btnClose    = document.getElementById('modalClose');

  function openModal()  { overlay.classList.add('active'); }
  function closeModal() { overlay.classList.remove('active'); }

  if (btnCreate)  btnCreate.addEventListener('click', openModal);
  if (btnHeader)  btnHeader.addEventListener('click', openModal);
  if (btnClose)   btnClose.addEventListener('click', closeModal);

  overlay && overlay.addEventListener('click', function (e) {
    if (e.target === overlay) closeModal();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModal();
  });

  /* ---- Demo button: highlight editable block ---- */
  const btnDemo      = document.getElementById('btnDemo');
  const editableBlock = document.getElementById('editableBlock');

  if (btnDemo && editableBlock) {
    btnDemo.addEventListener('click', function () {
      editableBlock.scrollIntoView({ behavior: 'smooth', block: 'center' });
      editableBlock.style.transition = 'box-shadow 0.3s';
      editableBlock.style.boxShadow  = '0 0 0 3px rgba(139,58,90,0.4)';
      setTimeout(function () {
        editableBlock.style.boxShadow = '';
      }, 1500);
    });
  }

  /* ---- Skill bar entrance animation ---- */
  var skillFills = document.querySelectorAll('.skill-fill, .mini-skill-fill');

  function animateSkills(entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        var el = entry.target;
        var targetWidth = el.style.width;
        el.style.width = '0%';
        requestAnimationFrame(function () {
          el.style.transition = 'width 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
          el.style.width = targetWidth;
        });
        observer.unobserve(el);
      }
    });
  }

  if ('IntersectionObserver' in window) {
    var skillObserver = new IntersectionObserver(animateSkills, { threshold: 0.1 });
    skillFills.forEach(function (el) { skillObserver.observe(el); });
  }

  /* ---- CV card hover depth effect ---- */
  var cvCards = document.querySelectorAll('.cv-card');

  cvCards.forEach(function (card) {
    card.addEventListener('mouseenter', function () {
      cvCards.forEach(function (c) {
        if (c !== card) c.style.filter = 'brightness(0.94)';
      });
    });
    card.addEventListener('mouseleave', function () {
      cvCards.forEach(function (c) { c.style.filter = ''; });
    });
  });

  /* ---- Nav active state ---- */
  var navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      navLinks.forEach(function (l) { l.classList.remove('active'); });
      link.classList.add('active');
    });
  });

  /* ---- Feature item click ---- */
  var featureItems = document.querySelectorAll('.feature-item');
  var featureMessages = [
    'Khám phá hơn 1000 mẫu CV chuẩn ATS cho mọi ngành nghề!',
    'AI gợi ý từ khóa giúp CV của bạn nổi bật hơn với nhà tuyển dụng.',
    'Xuất CV sang PDF, Word hoặc HTML chỉ với một cú nhấp chuột.',
    'Theo dõi ai đã xem CV của bạn và phân tích hiệu quả.',
    'Tham gia cộng đồng 50K+ người dùng và nhận mẹo nghề nghiệp.',
  ];

  featureItems.forEach(function (item, idx) {
    item.addEventListener('click', function () {
      var msg = featureMessages[idx] || 'Tính năng đang được phát triển.';
      showToast(msg);
    });
  });

  /* ---- Toast notification ---- */
  function showToast(message) {
    var existing = document.getElementById('cvToast');
    if (existing) existing.remove();

    var toast = document.createElement('div');
    toast.id = 'cvToast';
    toast.textContent = message;
    Object.assign(toast.style, {
      position:       'fixed',
      bottom:         '24px',
      left:           '50%',
      transform:      'translateX(-50%) translateY(20px)',
      background:     '#4a1a30',
      color:          '#fff',
      padding:        '12px 22px',
      borderRadius:   '999px',
      fontSize:       '13px',
      fontWeight:     '500',
      zIndex:         '999',
      boxShadow:      '0 8px 24px rgba(74,26,48,0.3)',
      opacity:        '0',
      transition:     'opacity 0.3s ease, transform 0.3s ease',
      whiteSpace:     'nowrap',
      maxWidth:       'calc(100vw - 48px)',
      textAlign:      'center',
      pointerEvents:  'none',
    });

    document.body.appendChild(toast);

    requestAnimationFrame(function () {
      toast.style.opacity   = '1';
      toast.style.transform = 'translateX(-50%) translateY(0)';
    });

    setTimeout(function () {
      toast.style.opacity   = '0';
      toast.style.transform = 'translateX(-50%) translateY(10px)';
      setTimeout(function () { toast.remove(); }, 300);
    }, 2800);
  }

  /* ---- Header scroll shadow ---- */
  var header = document.querySelector('.header');
  window.addEventListener('scroll', function () {
    if (window.scrollY > 8) {
      header.style.boxShadow = '0 2px 16px rgba(139,58,90,0.10)';
    } else {
      header.style.boxShadow = 'none';
    }
  }, { passive: true });

  /* ---- Search: focus ring ---- */
  var searchInput = document.querySelector('.search-bar input');
  var searchWrap  = document.querySelector('.search-bar');

  if (searchInput && searchWrap) {
    searchInput.addEventListener('focus',  function () { searchWrap.style.zIndex = '10'; });
    searchInput.addEventListener('blur',   function () { searchWrap.style.zIndex = '';  });
    searchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && searchInput.value.trim()) {
        showToast('Đang tìm kiếm: "' + searchInput.value.trim() + '"');
        searchInput.value = '';
        searchInput.blur();
      }
    });
  }

  /* ---- Typing placeholder loop ---- */
  var placeholders = [
    'Tìm mẫu CV, kỹ năng, ngành nghề...',
    'Marketing Manager CV...',
    'Mẫu CV kỹ thuật viên...',
    'CV cho sinh viên mới ra trường...',
    'Mẫu CV tiếng Anh chuẩn ATS...',
  ];
  var pIdx = 0;

  if (searchInput) {
    setInterval(function () {
      if (document.activeElement !== searchInput) {
        pIdx = (pIdx + 1) % placeholders.length;
        searchInput.placeholder = placeholders[pIdx];
      }
    }, 3500);
  }

  /* ---- Modal option actions ---- */
  var modalOptions = document.querySelectorAll('.modal-option');
  var optionToasts = [
    'Đang tải thư viện mẫu CV...',
    'Khởi động trợ lý AI của bạn...',
    'Đang kết nối với LinkedIn...',
  ];

  modalOptions.forEach(function (btn, idx) {
    btn.addEventListener('click', function () {
      closeModal();
      setTimeout(function () {
        showToast(optionToasts[idx] || 'Đang xử lý...');
      }, 200);
    });
  });

})();
