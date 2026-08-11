/* ==========================================================================
   admin-shell.js
   يبني التوب بار (admin-topbar) + السايدبار (admin-sidebar) + الفوتر (admin-footer)
   لكل صفحات لوحة تحكم الإدارة — مصدر واحد بدل ما يتكرر الكود بكل صفحة.
   ========================================================================== */
(function () {
  var current = window.location.pathname.split('/').pop() || 'overview.html';

  // ---------------------------------------------------------------------
  // إعدادات قابلة للتعديل بسهولة
  // ---------------------------------------------------------------------
  var SIDEBAR_TITLE = 'بوابة الإدارة';
  var SIDEBAR_SUBTITLE = 'نظام إدارة المعلومات';
  var SIDEBAR_HEAD_SHIFT = 10;

  // روابط السايدبار (بدون الإشعارات لأنها في الهيدر)
  var NAV_ITEMS = [
    {
      href: 'overview.html',
      label: 'نظرة عامة',
      icon: '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>'
    },
    {
      href: 'students.html',
      label: 'الطلاب',
      icon: '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'
    },
    {
      href: 'programs.html',
      label: 'البرامج الأكاديمية',
      icon: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h6"/>'
    },
    {
      href: 'statistics.html',
      label: 'إحصائيات',
      icon: '<path d="M4 20V10M12 20V4M20 20v-7"/>'
    },
    {
      href: 'support.html',
      label: 'الدعم الفني',
      icon: '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/><path d="M12 17h.01"/>'
    },
    {
      href: 'settings-dashboard.html',
      label: 'الإعدادات',
      icon: '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>'
    }
  ];

  function navLinkHTML(item) {
    var active = (item.href === current) ? ' active' : '';
    return (
      '<a href="' + item.href + '" class="admin-sidebar-link' + active + '">' +
        '<span class="link-label">' +
          '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' + item.icon + '</svg>' +
          item.label +
        '</span>' +
      '</a>'
    );
  }

  // ================================================================
  // 1. NOTIFICATIONS SYSTEM
  // ================================================================
  var NOTIFICATIONS_KEY = 'nextstep_notifications';

  var defaultNotifications = [
    { id: 1, title: 'طلب تسجيل جديد', message: 'أحمد محمود قدم طلب تسجيل في برنامج علوم الحاسوب.', time: 'منذ 5 دقائق', read: false, type: 'info' },
    { id: 2, title: 'تحديث الخطة الدراسية', message: 'تم تحديث خطة دراسة هندسة البرمجيات للفصل القادم.', time: 'منذ ساعة', read: false, type: 'success' },
    { id: 3, title: 'تنبيه: موعد نهائي', message: 'موعد تقديم طلبات التخرج يقترب (15 ديسمبر).', time: 'منذ 3 ساعات', read: false, type: 'warning' },
    { id: 4, title: 'تقرير جديد', message: 'تم إنشاء تقرير إحصائي عن الطلاب للفصل الحالي.', time: 'منذ 5 ساعات', read: true, type: 'info' },
    { id: 5, title: 'مشكلة تقنية', message: 'تم الإبلاغ عن عطل في نظام التسجيل. جارٍ الحل.', time: 'منذ يوم', read: true, type: 'error' },
    { id: 6, title: 'تحديث النظام', message: 'تم تحديث المنصة إلى الإصدار 2.4.0.', time: 'منذ يومين', read: true, type: 'success' },
    { id: 7, title: 'طلب استثناء', message: 'سارة خالد تقدمت بطلب استثناء لمادة الرياضيات.', time: 'منذ يومين', read: false, type: 'info' },
    { id: 8, title: 'اجتماع', message: 'اجتماع مجلس العمادة غداً الساعة 10 صباحاً.', time: 'منذ 3 أيام', read: true, type: 'warning' },
  ];

  function getNotifications() {
    var stored = localStorage.getItem(NOTIFICATIONS_KEY);
    if (stored) {
      try { return JSON.parse(stored); } catch(e) { /* ignore */ }
    }
    localStorage.setItem(NOTIFICATIONS_KEY, JSON.stringify(defaultNotifications));
    return defaultNotifications;
  }

  function saveNotifications(notifs) {
    localStorage.setItem(NOTIFICATIONS_KEY, JSON.stringify(notifs));
  }

  function getUnreadCount() {
    var notifs = getNotifications();
    return notifs.filter(function(n) { return !n.read; }).length;
  }

  function markAllAsRead() {
    var notifs = getNotifications();
    notifs.forEach(function(n) { n.read = true; });
    saveNotifications(notifs);
    updateNotificationBadge();
  }

  function clearAllNotifications() {
    saveNotifications([]);
    updateNotificationBadge();
  }

  function markAsRead(id) {
    var notifs = getNotifications();
    var found = notifs.find(function(n) { return n.id === id; });
    if (found) { found.read = true; saveNotifications(notifs); }
    updateNotificationBadge();
  }

  function deleteNotification(id) {
    var notifs = getNotifications();
    var filtered = notifs.filter(function(n) { return n.id !== id; });
    saveNotifications(filtered);
    updateNotificationBadge();
  }

  function updateNotificationBadge() {
    var count = getUnreadCount();
    var dot = document.querySelector('.admin-icon-btn .dot');
    if (dot) {
      if (count > 0) {
        dot.style.display = 'flex';
        dot.style.alignItems = 'center';
        dot.style.justifyContent = 'center';
        dot.style.fontSize = '9px';
        dot.style.fontWeight = '700';
        dot.style.width = '18px';
        dot.style.height = '18px';
        dot.style.borderRadius = '50%';
        dot.style.background = '#C62828';
        dot.style.color = '#fff';
        dot.style.top = '-4px';
        dot.style.right = '-4px';
        dot.style.border = '2px solid #fff';
        dot.textContent = count > 9 ? '9+' : count;
      } else {
        dot.style.display = 'none';
      }
    }
    var countEl = document.getElementById('notifCount');
    if (countEl) countEl.textContent = count;
  }

  // ================================================================
  // 2. BUILD TOPBAR (مع أيقونة الإشعارات)
  // ================================================================
  var unreadCount = getUnreadCount();

  var topbarContent =
    '<div class="admin-topbar-inner">' +
      '<a href="../../index.html" class="admin-brand">' +
        '<span class="brand-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg></span>' +
        '<span class="brand-text">NextStep AI</span>' +
      '</a>' +
      '<div class="admin-search">' +
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>' +
        '<input type="text" placeholder="ابحث عن طالب، برنامج، أو طلب...">' +
      '</div>' +
      '<div class="admin-user-actions">' +
        '<button type="button" class="admin-icon-btn" aria-label="المساعدة"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 2-3 4"/><path d="M12 17h.01"/></svg></button>' +
        '<a href="notifications.html" class="admin-icon-btn" aria-label="الإشعارات" style="text-decoration:none;color:inherit;position:relative;">' +
          '<span class="dot" style="' + (unreadCount > 0 ? 'display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;width:18px;height:18px;border-radius:50%;background:#C62828;color:#fff;position:absolute;top:-4px;right:-4px;border:2px solid #fff;' : 'display:none;') + '">' + (unreadCount > 9 ? '9+' : unreadCount) + '</span>' +
          '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>' +
        '</a>' +
        '<img src="../../assets/admin-avatar.png" alt="صورة المستخدم" class="admin-avatar" onerror="this.style.display=\'none\'">' +
      '</div>' +
    '</div>';

  // ================================================================
  // 3. BUILD SIDEBAR
  // ================================================================
  var sidebarContent =
    '<div class="admin-sidebar-head" style="padding-inline-start:' + SIDEBAR_HEAD_SHIFT + 'px;">' +
      '<h3>' + SIDEBAR_TITLE + '</h3>' +
      '<p>' + SIDEBAR_SUBTITLE + '</p>' +
    '</div>' +
    '<nav class="admin-sidebar-nav">' + NAV_ITEMS.map(navLinkHTML).join('') + '</nav>' +
    '<button type="button" class="admin-sidebar-cta" onclick="window.location.href=\'add-program.html\'">' +
      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5v14M5 12h14"/></svg>' +
      'إضافة برنامج جديد' +
    '</button>';

  // ================================================================
  // 4. BUILD FOOTER
  // ================================================================
  var footerContent =
    '<div class="admin-footer-inner">' +
      '<span>© 2026 NextStep AI — جميع الحقوق محفوظة</span>' +
      '<nav class="admin-footer-links">' +
        '<a href="support.html">الدعم الفني</a>' +
        '<a href="#">سياسة الخصوصية</a>' +
        '<a href="#">الشروط والأحكام</a>' +
      '</nav>' +
    '</div>';

  // ================================================================
  // 5. INJECT
  // ================================================================
  function inject() {
    var topbar = document.getElementById('adminTopbar');
    var sidebar = document.getElementById('adminSidebar');
    var footer = document.getElementById('adminFooter');

    if (topbar) {
      topbar.className = 'admin-topbar';
      topbar.innerHTML = topbarContent;
    } else {
      var topbarSlot = document.getElementById('admin-topbar-slot');
      if (topbarSlot) {
        topbarSlot.outerHTML = '<header class="admin-topbar" id="adminTopbar">' + topbarContent + '</header>';
      }
    }

    if (sidebar) {
      sidebar.className = 'admin-sidebar';
      sidebar.innerHTML = sidebarContent;
    } else {
      var sidebarSlot = document.getElementById('admin-sidebar-slot');
      if (sidebarSlot) {
        sidebarSlot.outerHTML = '<aside class="admin-sidebar" id="adminSidebar">' + sidebarContent + '</aside>';
      }
    }

    if (footer) {
      footer.className = 'admin-footer';
      footer.innerHTML = footerContent;
    } else {
      var footerSlot = document.getElementById('admin-footer-slot');
      if (footerSlot) {
        footerSlot.outerHTML = '<footer class="admin-footer" id="adminFooter">' + footerContent + '</footer>';
      }
    }

    var injectedTopbar = document.getElementById('adminTopbar');
    if (injectedTopbar) {
      window.addEventListener('scroll', function () {
        injectedTopbar.classList.toggle('scrolled', window.scrollY > 20);
      }, { passive: true });
    }

    updateNotificationBadge();
  }

  // ================================================================
  // 6. EXPOSE FUNCTIONS GLOBALLY
  // ================================================================
  window.NextStepNotifications = {
    getNotifications: getNotifications,
    saveNotifications: saveNotifications,
    getUnreadCount: getUnreadCount,
    markAllAsRead: markAllAsRead,
    clearAllNotifications: clearAllNotifications,
    markAsRead: markAsRead,
    deleteNotification: deleteNotification,
    updateNotificationBadge: updateNotificationBadge
  };

  // ================================================================
  // 7. INIT
  // ================================================================
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', inject);
  } else {
    inject();
  }
})();