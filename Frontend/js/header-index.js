/* header-index.js — يحقن الهيدر الخاص بصفحة index.html فقط
   (مختلف عن header.js العام: بدون قائمة موبايل، وزر واحد فقط "تسجيل دخول") */
(function () {

  document.write(
    '<header class="site-header">' +
      '<div class="nav-inner">' +
        '<a href="index.html" class="brand-mark">' +
          '<img src="assets/logo.png" alt="NextStep AI" class="brand-logo">' +
          '<div class="brand-text">NextStep<span>AI</span> </div>' +
        '</a>' +

        '<nav class="main-nav">' +
          '<ul>' +
            '<li><a href="../Frontend/fronted/how.html">عن المنصة</a></li>' +
            '<li><a href="../Frontend/fronted/universities.html">الجامعات</a></li>' +
            '<li><a href="../Frontend/fronted/quiz.html">الاختبار الذكي</a></li>' +
            '<li><a href="../Frontend/index.html" class="active">الرئيسية</a></li>' +
          '</ul>' +
        '</nav>' +

        '<div class="nav-actions">' +
          '<a href="../Frontend/fronted/signup.html" class="btn-signin">تسجيل دخول</a>' +
        '</div>' +
      '</div>' +
    '</header>'
  );

  function init() {
    var header = document.querySelector('header.site-header');
    if (!header) return;

    function onScroll() {
      if (window.scrollY > 20) header.classList.add('scrolled');
      else header.classList.remove('scrolled');
    }

    requestAnimationFrame(function () { header.classList.add('ready'); });
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();