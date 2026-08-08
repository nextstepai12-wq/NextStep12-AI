// header.js
// هيدر موحّد لكل صفحات الموقع — يكتشف مكانه تلقائياً (جذر الموقع أو مجلد fronted/)
// ويصحح كل المسارات لحاله، فمافي داعي تعدلي أي مسار يدوياً بأي صفحة.

(function () {
  const inFronted = window.location.pathname.includes('/fronted/');
  const rootPrefix = inFronted ? '../' : '';       // للوصول لـ index.html و assets/ من الجذر
  const frontedPrefix = inFronted ? '' : 'fronted/'; // للوصول لصفحات fronted (quiz, login, universities, about)

  document.write(`
<header class="site-header">
  <div class="nav-inner">
    <a href="${rootPrefix}index.html" class="brand-mark">
      <img src="${rootPrefix}assets/logo.png" alt="NextStep AI" class="brand-logo">
      <div class="brand-text">NextStep <span>AI</span></div>
    </a>

    <nav class="main-nav">
      <ul>
        <li><a href="${frontedPrefix}about.html">عن المنصة</a></li>
        <li><a href="${frontedPrefix}quiz.html">الاختبار الذكي</a></li>
        <li><a href="${frontedPrefix}universities.html">الجامعات</a></li>
        <li><a href="${rootPrefix}index.html">الرئيسية</a></li>
      </ul>
    </nav>

    <div class="nav-actions">
      <a href="${frontedPrefix}login.html">
        <button class="start-btn" type="button">
          ابدأ الآن
          <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
            <path d="M14 5l7 7-7 7M21 12H3" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </a>
      <a href="${frontedPrefix}login.html" class="btn-signin">تسجيل دخول</a>
    </div>
  </div>
</header>
<div class="header-spacer" id="headerSpacer"></div>
`);

  // نقيس ارتفاع الهيدر الفعلي (بيتغير حسب حجم الشاشة) ونطبّقه على الفاصل مباشرة
  // بدل رقم ثابت مخمّن — هيك ما بتصير مسافة زايدة أو ناقصة أبداً
  function syncHeaderSpacer(){
    const header = document.querySelector('header.site-header');
    const spacer = document.getElementById('headerSpacer');
    if (!header) return;
    const h = header.offsetHeight + 'px';
    document.documentElement.style.setProperty('--header-height', h);
    if (spacer) spacer.style.height = h;
  }
  window.addEventListener('load', syncHeaderSpacer);
  window.addEventListener('resize', syncHeaderSpacer);
  // تشغيل فوري كمان (قبل اكتمال تحميل الصور) عشان ما تصير قفزة بصرية
  document.addEventListener('DOMContentLoaded', syncHeaderSpacer);
})();