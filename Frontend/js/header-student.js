(function() {
    // 1. إضافة التنسيقات (CSS) إلى الـ Head إذا لم تكن موجودة
    if (!document.getElementById('nsa-dynamic-styles')) {
        const style = document.createElement('style');
        style.id = 'nsa-dynamic-styles';
        style.textContent = `
            :root{ --student-bg: #F4F7FC; --student-primary: #173873; --student-blue: #2F6BFF; --student-cyan: #35D0FF; --student-mint: #4BE6B5; --student-red: #C62828; --student-gray: #5B6B79; --student-gray-light: #D9DFE7; --student-shadow: 0 4px 20px rgba(23,56,115,0.06); --student-shadow-hover: 0 8px 40px rgba(23,56,115,0.10); --student-radius: 20px; --student-radius-sm: 12px; --student-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
            .nsa-topbar{ position: fixed; top: 0; left: 0; right: 0; width: 100%; z-index: 1000; height: 76px; padding: 0 32px; display:flex; align-items:center; background: rgba(247,250,252,0.85); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(47,107,255,0.08); transition: transform .4s cubic-bezier(0.4, 0, 0.2, 1); }
            .nsa-topbar.hidden{ transform: translateY(-110%); }
            .nsa-topbar-inner{ width:100%; display:flex; align-items:center; justify-content:space-between; gap:24px; }
            
            /* تنسيقات الشعار */
            .nsa-brand{ display:flex; align-items:center; gap:10px; text-decoration:none; color: var(--student-primary); font-weight:800; font-size:1.15rem; }
            .nsa-brand-icon{ display:flex; align-items:center; justify-content:center; width:38px; height:38px; background: linear-gradient(135deg, var(--student-primary), var(--student-blue)); border-radius: var(--student-radius-sm); color:white; box-shadow: 0 2px 10px rgba(23,56,115,0.2); }
            .nsa-brand-icon svg{ width:22px; height:22px; }
            .nsa-brand span { color: var(--student-blue); }
        `;
        document.head.appendChild(style);
    }

    // 2. إنشاء الهيكل (HTML) الخاص بالهيدر
    const headerHTML = `
        <header class="nsa-topbar" id="topbar">
            <div class="nsa-topbar-inner">
                <!-- يمين: المستخدم -->
                <div class="nsa-user">
                    <button class="nsa-avatar-btn" id="nsaUserBtn" aria-expanded="false">
                        <img src="https://images.unsplash.com/photo-1618077360395-f3068be8e001?w=300&h=300&fit=crop&crop=faces" alt="صورة المستخدم" class="nsa-avatar">
                        <span class="nsa-user-name">أحمد محمد</span>
                        <svg class="nsa-user-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                </div>

                <!-- وسط: البحث -->
                <div class="nsa-search">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" placeholder="ابحث عن تخصص، جامعة، أو سؤال...">
                </div>

                <!-- يسار: الشعار (الصورة بجانب النص) -->
                <dijv class="nsa-left">
                    <a href="student-dashboard.html" class="nsa-brand">
                        <div class="nsa-brand-icon">
                           <img src=" alt="صورة المستخدم" class="nsa-brand">
                        </div>
                        NextStep <span>AI</span>
                    </a>
                </div>
            </div>
        </header>
    `;

    // 3. حقن الهيدر في بداية الـ Body
    document.body.insertAdjacentHTML('afterbegin', headerHTML);

    // 4. تفعيل تأثير السكرول (إخفاء وإظهار الهيدر)
    let lastScroll = 0;
    const topbarElement = document.getElementById('topbar');
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 50) {
            topbarElement.classList.add('tinted');
            if (currentScroll > lastScroll && currentScroll > 150) {
                topbarElement.classList.add('hidden');
            } else {
                topbarElement.classList.remove('hidden');
            }
        } else {
            topbarElement.classList.remove('tinted', 'hidden');
        }
        lastScroll = currentScroll;
    }, { passive: true });
})();