/* ============================================================
   header-dashboard.js
   NextStep AI — Premium Animated Header (Dashboard Version)
   نفس هيدر header-index.js بالضبط، بس بدل زر "تسجيل دخول"
   بيعرض شعار الحساب + قائمة منسدلة (بروفايل / إعدادات / خروج)
   ============================================================ */

(function () {

    var path = window.location.pathname;

    var inSubfolder =
        path.toLowerCase().includes('/fronted') ||
        path.toLowerCase().includes('/frontend');

    var root = inSubfolder ? '../' : '';
    var pg = inSubfolder ? '' : 'Frontend/fronted/';


    /* ========================================================
       HEADER HTML
       ======================================================== */

    document.write(

        '<header class="site-header">' +

            /* عناصر الحركة الخلفية */
            '<span class="header-orb orb-one"></span>' +
            '<span class="header-orb orb-two"></span>' +
            '<span class="header-orb orb-three"></span>' +

            '<div class="nav-inner">' +

                /* =================================================
                   BRAND
                   ================================================= */

                '<a href="' + root + '../index.html" class="brand-mark">' +

                    '<span class="brand-logo-box">' +

                        '<img src="' + root + '../Frontend/assets/images/brand-logo.png" ' +
                             'alt="NextStep AI" ' +
                             'class="brand-logo">' +

                    '</span>' +

                    '<div class="brand-text">' +
                        'NextStep<span>AI</span>' +
                    '</div>' +

                '</a>' +


                /* =================================================
                   NAVIGATION
                   ================================================= */

                '<nav class="main-nav">' +

                    '<ul>' +

                        '<li>' +
                            '<a href="' + pg + '../about.html">' +
                                '<span>عن المنصة</span>' +
                                '<span class="nav-icon">' +
                                    '<svg viewBox="0 0 24 24" aria-hidden="true">' +
                                        '<circle cx="12" cy="8" r="4" />' +
                                        '<path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8" />' +
                                    '</svg>' +
                                '</span>' +
                            '</a>' +
                        '</li>' +

                        '<li>' +
                            '<a href="' + pg + '../universities.html">' +
                                '<span>الجامعات</span>' +
                                '<span class="nav-icon">' +
                                    '<svg viewBox="0 0 24 24" aria-hidden="true">' +
                                        '<path d="M12 3 2 8l10 5 10-5-10-5Z" />' +
                                        '<path d="M6 10.5V16c0 1.7 2.7 3 6 3s6-1.3 6-3v-5.5" />' +
                                    '</svg>' +
                                '</span>' +
                            '</a>' +
                        '</li>' +

                        '<li>' +
                            '<a href="' + pg + '../quiz.html">' +
                                '<span>الاختبار الذكي</span>' +
                                '<span class="nav-icon">' +
                                    '<svg viewBox="0 0 24 24" aria-hidden="true">' +
                                        '<path d="M4 20V10" />' +
                                        '<path d="M10 20V4" />' +
                                        '<path d="M16 20v-7" />' +
                                        '<path d="M20 20v-3" />' +
                                    '</svg>' +
                                '</span>' +
                            '</a>' +
                        '</li>' +

                        '<li>' +
                            '<a href="' + root + '../index.html">' +
                                '<span>الرئيسية</span>' +
                                '<span class="nav-icon">' +
                                    '<svg viewBox="0 0 24 24" aria-hidden="true">' +
                                        '<path d="M4 11.5 12 4l8 7.5" />' +
                                        '<path d="M6 10v9a1 1 0 0 0 1 1h4v-5h2v5h4a1 1 0 0 0 1-1v-9" />' +
                                    '</svg>' +
                                '</span>' +
                            '</a>' +
                        '</li>' +

                    '</ul>' +

                '</nav>' +


                /* =================================================
                   ACTIONS — شعار الحساب بدل زر تسجيل الدخول
                   ================================================= */

                '<div class="nav-actions">' +

                    /* زر الإشعارات */
                    /* رابط زر الإشعارات */
                    '<a href="' + pg + '../student/notifications.html" class="icon-btn notif-btn" aria-label="الإشعارات">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                            '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />' +
                            '<path d="M13.73 21a2 2 0 0 1-3.46 0" />' +
                        '</svg>' +
                        '<span class="notif-badge"></span>' +
                    '</a>' +

                    /* حساب المستخدم + القائمة المنسدلة */
                    '<div class="account-wrap">' +

                        '<button class="account-trigger" id="accountTrigger" type="button" aria-haspopup="true" aria-expanded="false">' +

                            '<span class="user-avatar">' +
                                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                                    '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />' +
                                    '<circle cx="12" cy="7" r="4" />' +
                                '</svg>' +
                            '</span>' +

                            '<span class="account-meta">' +
                                '<span class="name">اسم الطالب</span>' +
                                '<span class="role">حساب طالب</span>' +
                            '</span>' +

                            '<svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">' +
                                '<path d="m6 9 6 6 6-6" />' +
                            '</svg>' +

                        '</button>' +

                        '<div class="dropdown" id="accountDropdown">' +

                            '<div class="dd-head">' +
                                '<span class="user-avatar">' +
                                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                                        '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />' +
                                        '<circle cx="12" cy="7" r="4" />' +
                                    '</svg>' +
                                '</span>' +
                                '<div>' +
                                    '<div class="name">اسم الطالب</div>' +
                                    '<div class="role">حساب طالب</div>' +
                                '</div>' +
                            '</div>' +

                            '<div class="dd-list">' +

                                '<a href="' + pg + '../student/student-profile.html" class="dd-item">' +
                                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>' +
                                    'ملفي الشخصي' +
                                '</a>' +

                                '<a href="' + pg + '../student/student-settings.html" class="dd-item">' +
                                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87M4.6 9a1.7 1.7 0 0 0-.34-1.87"/><path d="M12 3v.09M12 20.9V21M3 12h.09M20.9 12H21"/></svg>' +
                                    'الإعدادات' +
                                '</a>' +

                                '<div class="dd-divider"></div>' +

                                '<a href="' + root + '../index.html" class="dd-item logout">' +
                                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>' +
                                    'تسجيل الخروج' +
                                '</a>' +

                            '</div>' +

                        '</div>' +

                    '</div>' +

                '</div>' +

            '</div>' +

        '</header>'
    );


    /* ============================================================
       INIT
       ============================================================ */

    function init() {

        var header =
            document.querySelector('.site-header');

        if (!header) return;


        /* ========================================================
           SCROLL
           ======================================================== */

        function onScroll() {

            if (window.scrollY > 20) {

                header.classList.add('scrolled');

            } else {

                header.classList.remove('scrolled');

            }

        }


        /* ========================================================
           MOUSE PARALLAX
           ======================================================== */

        var orbs =
            header.querySelectorAll('.header-orb');

        var mouseX = 0;
        var mouseY = 0;

        var currentX = 0;
        var currentY = 0;


        function mouseMove(e) {

            var x =
                (e.clientX / window.innerWidth) - 0.5;

            var y =
                (e.clientY / window.innerHeight) - 0.5;

            mouseX = x;
            mouseY = y;

        }


        function animateParallax() {

            currentX +=
                (mouseX - currentX) * 0.035;

            currentY +=
                (mouseY - currentY) * 0.035;


            if (orbs.length) {

                orbs[0].style.transform =
                    'translate(' +
                    (currentX * 18) +
                    'px,' +
                    (currentY * 10) +
                    'px)';

                if (orbs[1]) {

                    orbs[1].style.transform =
                        'translate(' +
                        (currentX * -12) +
                        'px,' +
                        (currentY * -8) +
                        'px)';

                }

                if (orbs[2]) {

                    orbs[2].style.transform =
                        'translate(' +
                        (currentX * 8) +
                        'px,' +
                        (currentY * -5) +
                        'px)';

                }

            }


            requestAnimationFrame(
                animateParallax
            );

        }


        /* ========================================================
           ACTIVE LINK
           ======================================================== */

        var links =
            header.querySelectorAll('.main-nav a');

        var currentPage =
            window.location.pathname
                .split('/')
                .pop()
                .toLowerCase();


        links.forEach(function (link) {

            var href =
                link.getAttribute('href') || '';

            var linkPage =
                href
                    .split('/')
                    .pop()
                    .toLowerCase();


            if (
                linkPage &&
                linkPage === currentPage
            ) {

                link.classList.add('active');

            }

        });


        /* ========================================================
           ACCOUNT DROPDOWN
           ======================================================== */

        var trigger =
            header.querySelector('#accountTrigger');

        var dropdown =
            header.querySelector('#accountDropdown');


        if (trigger && dropdown) {

            trigger.addEventListener('click', function (e) {

                e.stopPropagation();

                var isOpen =
                    dropdown.classList.toggle('open');

                trigger.setAttribute(
                    'aria-expanded',
                    isOpen ? 'true' : 'false'
                );

            });


            document.addEventListener('click', function (e) {

                if (
                    !dropdown.contains(e.target) &&
                    !trigger.contains(e.target)
                ) {

                    dropdown.classList.remove('open');

                    trigger.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }

            });


            document.addEventListener('keydown', function (e) {

                if (e.key === 'Escape') {

                    dropdown.classList.remove('open');

                    trigger.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }

            });

        }


        /* ========================================================
           HEADER READY
           ======================================================== */

        requestAnimationFrame(function () {

            header.classList.add('ready');

            onScroll();

            animateParallax();

        });


        /* ========================================================
           EVENTS
           ======================================================== */

        window.addEventListener(
            'scroll',
            onScroll,
            { passive: true }
        );


        window.addEventListener(
            'mousemove',
            mouseMove,
            { passive: true }
        );

    }


    /* ============================================================
       START
       ============================================================ */

    if (
        document.readyState === 'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            init
        );

    } else {

        init();

    }

})();