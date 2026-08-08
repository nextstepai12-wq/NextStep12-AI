/**
 * include-partials.js
 */

(function () {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';

  function markActiveLinks(container) {
    if (!container) return;
    container.querySelectorAll('a[href]').forEach((link) => {
      const href = link.getAttribute('href').split('/').pop();
      if (href === currentPage) {
        link.classList.add('active');
      }
    });
  }

  function loadPartial(url, placeholderId, callback) {
    const placeholder = document.getElementById(placeholderId);
    if (!placeholder) return;

    // استخدام المسار المباشر الموازي للملفات
    fetch(url)
      .then((res) => {
        if (!res.ok) throw new Error(`فشل تحميل ${url} (الكود: ${res.status})`);
        return res.text();
      })
      .then((html) => {
        placeholder.outerHTML = html;
        if (callback) callback();
      })
      .catch((err) => {
        console.error(`❌ خطأ في تحميل ${placeholderId}:`, err);
        placeholder.innerHTML = `<p style="color:red; text-align:center; padding:15px; background:#ffe6e6;">
          تعذر تحميل <b>${url}</b>
        </p>`;
      });
  }

  document.addEventListener('DOMContentLoaded', () => {
    // جلب الهيدر والفوتر من المجلد الحالي مباشرة
    loadPartial('header.html', 'header-placeholder', () => {
      markActiveLinks(document.querySelector('.site-header'));
      initHeaderBehavior();
    });

    loadPartial('footer.html', 'footer-placeholder');
  });

  function initHeaderBehavior() {
    const token = localStorage.getItem('token');
    const signInBtn = document.querySelector('.btn-signin');
    if (token && signInBtn) {
      signInBtn.textContent = 'حسابي';
      signInBtn.setAttribute('href', 'profile.html');
    }
  }
})();