function renderSidebar(containerSelector = 'body', activePageHref = '') {
    const container = document.querySelector(containerSelector);
    if (!container) return;

    const sidebarHTML = `
    <aside class="sidebar">
        <div class="group-label">القائمة الرئيسية</div>
        <nav>
            <a href="../student/student-dashboard.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5L12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg>
                لوحة الطالب
            </a>
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                النتائج والتوصيات
            </a>
            <a href="../../fronted/quiz.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="0.6" fill="currentColor"/></svg>
                الاختيار الذكي
            </a>
            <a href="../universities.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l4 8H8l4-8z"/><rect x="4" y="14" width="16" height="7" rx="1.5"/></svg>
                الجامعات
            </a>
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2"/><path d="M9 4v16M4 9h5"/></svg>
                التخصصات
            </a>
            <a href="../chatbot.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.4 8.4 0 0 1-8.8 8.4 8.5 8.5 0 0 1-4-1L3 20l1.1-4A8.4 8.4 0 1 1 21 11.5z"/></svg>
                المساعد الذكي
            </a>
            <a href="../student/scholarships.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5L12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg>
                المنح
            </a>
        </nav>

        <div class="group-label">أدواتي</div>
        <nav>
            <a href="../../fronted/student/favorites.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 17.3l-6.2 3.6 1.6-7L2 9.2l7.1-.6L12 2l2.9 6.6 7.1.6-5.4 4.7 1.6 7z"/></svg>
                المفضلة
            </a>
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                المقارنات
            </a>
        </nav>

        <div class="group-label">حسابي</div>
        <nav>
            <a href="../../fronted/student/student-profile.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.87 3.13-6 7-6s7 2.13 7 6"/></svg>
                ملفي الشخصي
            </a>
            <a href="../../fronted/student/student-settings.html" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87M4.6 9a1.7 1.7 0 0 0-.34-1.87"/><path d="M12 3v.09M12 20.9V21M3 12h.09M20.9 12H21"/></svg>
                الإعدادات
            </a>
            <hr>
            <a href="../../index.html" class="nav-item logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                تسجيل الخروج
            </a>
        </nav>
    </aside>
    `;

    container.insertAdjacentHTML('afterbegin', sidebarHTML);

    // تفعيل الرابط المطابق للصفحة الحالية تلقائياً
    if (activePageHref) {
        const activeItem = container.querySelector(`.sidebar a[href="${activePageHref}"]`);
        if (activeItem) {
            activeItem.classList.add('active');
        }
    }
}