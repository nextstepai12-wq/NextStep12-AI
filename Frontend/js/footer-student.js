document.addEventListener("DOMContentLoaded", function() {
    const footerHTML = `
    <footer class="site-footer">
      <div class="footer-inner">
        <div class="footer-top">

          <!-- Brand -->
          <div class="footer-col footer-brand">
            <div class="brand-mark">
              <div class="brand-text">NextStep<span>AI</span></div>
              <img src="../assets/logo.png" alt="NextStep AI" class="brand-logo">
            </div>
            <div class="logo2">   
              <span>خطوتك الذكية نحو مستقبلك</span>
              <p class="lead">منصة ذكية تساعدك على اكتشاف التخصص المناسب واختيار الجامعة الأفضل لك من خلال الذكاء الاصطناعي.</p>
            </div>
            <div class="social-row">
              <a href="https://www.instagram.com/nextstepai12?igsi=MWlwbm5wazl5dDJpdw==" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 448" width="448" height="448">
                  <defs>
                    <linearGradient id="instagram" x1="0%" y1="100%" x2="100%" y2="0%">
                      <stop offset="0%" stop-color="#feda75"/>
                      <stop offset="25%" stop-color="#fa7e1e"/>
                      <stop offset="50%" stop-color="#d62976"/>
                      <stop offset="75%" stop-color="#962fbf"/>
                      <stop offset="100%" stop-color="#4f5bd5"/>
                    </linearGradient>
                  </defs>
                  <rect width="448" height="448" rx="100" ry="100" fill="url(#instagram)"/>
                  <path fill="#fff" fill-rule="evenodd" d="M112 80h224c17.7 0 32 14.3 32 32v224c0 17.7-14.3 32-32 32H112c-17.7 0-32-14.3-32-32V112c0-17.7 14.3-32 32-32zm0 32v224h224V112H112z"/>
                  <circle cx="224" cy="224" r="70" fill="none" stroke="#fff" stroke-width="32"/>
                  <circle cx="320" cy="128" r="22" fill="#fff"/>
                </svg>         
              </a>
              <a href="#" aria-label="Twitter/X">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
                  <path fill="#000000" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>         
              </a>
              <a href="https://www.linkedin.com/in/nextstepai/" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
                  <path fill="#0A66C2" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>         
              </a>
              <div class="popover-wrapper">
                <a href="#" aria-label="YouTube" class="soon-trigger">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="#FF0000" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/>
                    <path fill="#FFFFFF" d="M9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                  </svg> 
                </a>
                <div class="soon-popover">Soon</div>
              </div>
            </div>
          </div>

          <!-- Site pages -->
          <div class="footer-col">
            <h4>روابط الموقع</h4>
            <ul>
              <li><a href="../Frontend/index.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/></svg>الرئيسية</a></li>
              <li><a href="../Frontend/fronted/auth/login.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M8 2v4M16 2v4M3 10h18"/></svg>اختبار الاستكشاف</a></li>
              <li><a href="../Frontend/fronted/auth/"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>الخطة الدراسية</a></li>
              <li><a href="../Frontend/fronted/universities.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>الجامعات</a></li>
            </ul>
          </div>

          <!-- Contact us -->
          <div class="footer-col">
            <h4>تواصل معنا</h4>
            <div class="contact-item">
              <div class="icon-wrap"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" opacity="0"/><path d="M22 6l-10 7L2 6"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg></div>
              <a href="mailto:info@nextstepai.com?subject=استفسار من موقع NextStep AI&body=مرحباً فريق NextStep AI،">تواصل معنا</a>
            </div>
            <div class="contact-item">
              <div class="icon-wrap"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.62 2.6a2 2 0 0 1-.45 2.11L8.09 9.62a16 16 0 0 0 6 6l1.19-1.19a2 2 0 0 1 2.11-.45c.83.29 1.7.5 2.6.62A2 2 0 0 1 22 16.92z"/></svg></div>
              <a href="tel:+970000000">+970 59 796 7157</a>
            </div>
            <div class="contact-item">
              <div class="icon-wrap"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
              <span>غزة، فلسطين</span>
            </div>
          </div>

          <!-- Information -->
          <div class="footer-col">
            <h4>معلومات</h4>
            <ul>
              <li><a href="../Frontend/fronted/about.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>من نحن</a></li>
              <li><a href="../Frontend/fronted/privacy-policy.html"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/></svg>سياسة الخصوصية</a></li>
              <li><a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>الشروط والأحكام</a></li>
              <li><a href="#"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.5 9a2.5 2.5 0 0 1 5 0c0 1.5-2 2-2 3.5M12 17h.01"/></svg>الأسئلة الشائعة</a></li>
            </ul>
          </div>

        </div>

        <div class="footer-bottom">
          <p>© 2026 NextStep AI. جميع الحقوق محفوظة.</p>
        </div>
      </div>
    </footer>
    `;

    // إدراج الفوتر تلقائياً في نهاية الـ body أو في مكان مخصص
    document.body.insertAdjacentHTML('beforeend', footerHTML);
});