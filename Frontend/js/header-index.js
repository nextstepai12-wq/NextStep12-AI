/* ============================================================
   header-index.js
   NextStep AI — Premium Animated Header
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

                '<a href="' + root + 'index.html" class="brand-mark">' +

                    '<span class="brand-logo-box">' +

                        '<img src="' + root + 'assets/logo.png" ' +
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
                            '<a href="' + pg + 'about.html">' +
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
                            '<a href="' + pg + 'universities.html">' +
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
                            '<a href="' + pg + 'quiz.html">' +
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
                            '<a href="' + root + 'index.html">' +
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
                   ACTIONS
                   ================================================= */

                '<div class="nav-actions">' +

                    '<a href="' + pg + 'signup.html" class="btn-signin">' +
                        '<span>تسجيل دخول</span>' +
                    '</a>' +

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
           حركة خفيفة جدًا للأشكال فقط
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


        /* ========================================================
           BUTTON MICRO INTERACTION
           ======================================================== */

        var buttons =
            header.querySelectorAll(
                '.btn-signin'
            );


        buttons.forEach(function (button) {

            button.addEventListener(
                'mouseenter',
                function () {

                    button.classList.add(
                        'is-hovered'
                    );

                }
            );


            button.addEventListener(
                'mouseleave',
                function () {

                    button.classList.remove(
                        'is-hovered'
                    );

                }
            );

        });

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