/* header-index.js — يحقن الهيدر الخاص بصفحة index.html فقط
   (مختلف عن header.js العام: بدون قائمة موبايل، وزر واحد فقط "تسجيل دخول") */
(function () {
  // معرفة مكان الصفحة الحالية بالنسبة للجذر
  var path = window.location.pathname;
  
  // فحص إذا كنا داخل مجلد فرعي (سواء fronted أو frontend)
  var inSubfolder = path.toLowerCase().includes('/fronted') || path.toLowerCase().includes('/frontend');

  // إذا كنا بالداخل نحتاج الخروج خطوة للخلف '../' للوصول إلى assets و index.html الرئيسي
  var root = inSubfolder ? '../' : ''; 
  // مسار الوصول لصفحات مجلد الفرونت إند من الجذر
  var pg = inSubfolder ? '' : 'Frontend/fronted/';

  document.write(
    '<header class="site-header">' +
      '<div class="nav-inner">' +
        '<a href="' + root + 'index.html" class="brand-mark">' +
          '<img src="' + root + 'assets/logo.png" alt="NextStep AI" class="brand-logo">' +
          '<div class="brand-text">NextStep<span>AI</span> </div>' +
        '</a>' +

        '<nav class="main-nav">' +
          '<ul>' +
            '<li><a href="' + pg + 'about.html">عن المنصة</a></li>' +
            '<li><a href="' + pg + 'universities.html">الجامعات</a></li>' +
            '<li><a href="' + pg + 'quiz.html">الاختبار الذكي</a></li>' +
            '<li><a href="' + root + 'index.html" class="active">الرئيسية</a></li>' +
          '</ul>' +
        '</nav>' +

        '<div class="nav-actions">' +
          '<a href="' + pg + 'signup.html" class="btn-signin">تسجيل دخول</a>' +
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