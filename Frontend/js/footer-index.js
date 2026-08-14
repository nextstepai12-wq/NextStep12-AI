/* footer-index.js — يحقن الفوتر الخاص بصفحة index.html فقط */
(function () {

  document.write(
    '<footer class="site-footer">' +
      '<div class="footer-inner">' +
        '<div class="footer-top">' +

          '<div class="footer-col footer-brand">' +
            '<div class="brand-mark">' +
              '<img src="../assets/logo.png" alt="NextStep AI" class="brand-logo">' +
              '<div class="brand-text">NextStep <span>AI</span></div>' +
            '</div>' +
            '<div class="logo2">' +
              '<span>خطوتك الذكية نحو مستقبلك</span>' +
              '<p class="lead">منصة ذكية تساعدك على اكتشاف التخصص المناسب واختيار الجامعة الأفضل لك من خلال الذكاء الاصطناعي.</p>' +
            '</div>' +
            '<div class="social-row">' +
              '<a href="https://www.instagram.com/nextstepai12/" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg></a>' +
              '<a href="#" aria-label="Twitter/X"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4l16 16M20 4L4 20"/></svg></a>' +
              '<a href="https://www.linkedin.com/in/nextstepai/" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="3"/><line x1="7" y1="10" x2="7" y2="17"/><circle cx="7" cy="7" r="0.5" fill="currentColor"/><path d="M11 17v-4a2 2 0 0 1 4 0v4"/><line x1="11" y1="10" x2="11" y2="17"/></svg></a>' +
              '<a href="#" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="4"/><path d="M10 9.5l5 2.5-5 2.5z" fill="currentColor" stroke="none"/></svg></a>' +
            '</div>' +
          '</div>' +

          '<div class="footer-col">' +
            '<h4>روابط الموقع</h4>' +
            '<ul>' +
              '<li><a href="../../Frontend/index.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg>الرئيسية</a></li>' +
              '<li><a href="../../Frontend/fronted/signup.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>اختبار الاستكشاف</a></li>' +
              '<li><a href="../../Frontend/fronted/signup.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>الخطة الدراسية</a></li>' +
              '<li><a href="../../Frontend/fronted/universities.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>الجامعات</a></li>' +
            '</ul>' +
          '</div>' +

          '<div class="footer-col">' +
            '<h4>تواصل معنا</h4>' +
            '<div class="contact-item">' +
              '<div class="icon-wrap"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 6l-10 7L2 6"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg></div>' +
              '<a href="mailto:info@nextstepai.com?subject=استفسار من موقع NextStep AI&body=مرحباً فريق NextStep AI،">تواصل معنا</a>' +
            '</div>' +
            '<div class="contact-item">' +
              '<div class="icon-wrap"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.62 2.6a2 2 0 0 1-.45 2.11L8.09 9.62a16 16 0 0 0 6 6l1.19-1.19a2 2 0 0 1 2.11-.45c.83.29 1.7.5 2.6.62A2 2 0 0 1 22 16.92z"/></svg></div>' +
              '<a href="tel:+970000000">+970 59 796 7157</a>' +
            '</div>' +
            '<div class="contact-item">' +
              '<div class="icon-wrap"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>' +
              '<span>غزة، فلسطين</span>' +
            '</div>' +
          '</div>' +

          '<div class="footer-col">' +
            '<h4>معلومات</h4>' +
            '<ul>' +
              '<li><a href="about.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>من نحن</a></li>' +
              '<li><a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/></svg>سياسة الخصوصية</a></li>' +
              '<li><a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>الشروط والأحكام</a></li>' +
              '<li><a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.5 9a2.5 2.5 0 0 1 5 0c0 1.5-2 2-2 3.5M12 17h.01"/></svg>الأسئلة الشائعة</a></li>' +
            '</ul>' +
          '</div>' +

        '</div>' +

        '<div class="footer-bottom">' +
          '<p>© 2026 NextStep AI. جميع الحقوق محفوظة.</p>' +
        '</div>' +
      '</div>' +
    '</footer>'
  );

})();