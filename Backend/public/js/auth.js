/* auth.js — أدوات مشتركة لصفحات المصادقة: إظهار كلمة المرور + توست */
(function () {
  // ---- إظهار/إخفاء كلمة المرور ----
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.toggle-password');
    if (!btn) return;
    var input = document.getElementById(btn.dataset.target);
    if (!input) return;
    var toText = input.type === 'password';
    input.type = toText ? 'text' : 'password';
    var eye = btn.querySelector('.icon-eye');
    var eyeOff = btn.querySelector('.icon-eye-off');
    if (eye && eyeOff) {
      eye.style.display = toText ? 'none' : 'block';
      eyeOff.style.display = toText ? 'block' : 'none';
    }
    btn.setAttribute('aria-label', toText ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور');
  });

  // ---- توست ----
  window.showToast = function (message, type) {
    var el = document.createElement('div');
    el.className = 'toast ' + (type || '');
    var icon = type === 'error'
      ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6M9 9l6 6"/></svg>'
      : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>';
    el.innerHTML = icon + '<span></span>';
    el.querySelector('span').textContent = message;
    document.body.appendChild(el);
    requestAnimationFrame(function () { el.classList.add('show'); });
    setTimeout(function () {
      el.classList.remove('show');
      setTimeout(function () { el.remove(); }, 320);
    }, 3200);
  };
})();