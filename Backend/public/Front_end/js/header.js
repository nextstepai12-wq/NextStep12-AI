/* header.js — يحقن الهيدر الموحّد ويصحّح المسارات تلقائياً
   يعمل من الجذر (index.html) ومن مجلد pages/ على حدٍّ سواء. */
(function () {
  var inPages = window.location.pathname.includes('/pages/');
  var root = inPages ? '../' : '';          // للوصول إلى index.html و assets/
  var pg = inPages ? '' : 'pages/';         // للوصول إلى صفحات pages/

  // اسم الملف الحالي لتمييز الرابط النشط
  var current = window.location.pathname.split('/').pop() || 'index.html';

  function link(href, label, matchers) {
    var active = matchers.indexOf(current) !== -1 ? ' class="active"' : '';
    return '<li><a href="' + href + '"' + active + '>' + label + '</a></li>';
  }

  var navLinks =
    link(root + 'index.html', 'الرئيسية', ['index.html', '']) +
    link(pg + 'about.html', 'عن المنصة', ['about.html']) +
    link(pg + 'quiz.html', 'الاختبار الذكي', ['quiz.html']) +
    link(pg + 'universities.html', 'الجامعات', ['universities.html']);

  var actionsDesktop =
    '<a href="' + pg + 'login.html" class="btn btn-outline btn-signin-desktop">تسجيل دخول</a>' +
    '<a href="' + pg + 'signup.html" class="btn btn-primary start-btn-desktop">' +
      'ابدأ الآن' +
      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>' +
    '</a>';

  document.write(
    '<header class="site-header">' +
      '<div class="nav-inner">' +
        '<a href="' + root + 'index.html" class="brand-mark" aria-label="NextStep AI — الرئيسية">' +
          '<img src="' + root + 'assets/logo.png" alt="" class="brand-logo">' +
          '<span class="brand-text">NextStep <span>AI</span></span>' +
        '</a>' +
        '<nav class="main-nav" aria-label="التنقل الرئيسي"><ul>' + navLinks + '</ul></nav>' +
        '<div class="nav-actions">' +
          actionsDesktop +
          '<button class="nav-toggle" type="button" aria-label="القائمة" aria-expanded="false">' +
            '<svg class="icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>' +
            '<svg class="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>' +
          '</button>' +
        '</div>' +
      '</div>' +
      '<div class="mobile-menu">' +
        '<ul>' + navLinks + '</ul>' +
        '<div class="mobile-actions">' +
          '<a href="' + pg + 'login.html" class="btn btn-outline btn-block">تسجيل دخول</a>' +
          '<a href="' + pg + 'signup.html" class="btn btn-primary btn-block">ابدأ الآن</a>' +
        '</div>' +
      '</div>' +
    '</header>' +
    '<div class="header-spacer"></div>'
  );

  function init() {
    var header = document.querySelector('header.site-header');
    var toggle = document.querySelector('.nav-toggle');
    var spacer = document.querySelector('.header-spacer');

    function syncSpacer() {
      if (!header || !spacer) return;
      var h = header.offsetHeight;
      document.documentElement.style.setProperty('--header-height', h + 'px');
      spacer.style.height = h + 'px';
    }
    syncSpacer();
    window.addEventListener('resize', syncSpacer);
    window.addEventListener('load', syncSpacer);

    // تأثير الظل عند التمرير
    function onScroll() {
      if (window.scrollY > 8) header.classList.add('is-scrolled');
      else header.classList.remove('is-scrolled');
    }
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    // قائمة الموبايل
    if (toggle) {
      toggle.addEventListener('click', function () {
        var open = document.body.classList.toggle('nav-open');
        toggle.setAttribute('aria-expanded', String(open));
      });
      document.querySelectorAll('.mobile-menu a').forEach(function (a) {
        a.addEventListener('click', function () {
          document.body.classList.remove('nav-open');
          toggle.setAttribute('aria-expanded', 'false');
        });
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
