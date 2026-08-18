/* ============================================================
   header-index.js
   الهيدر الموحّد + header-spacer
   ============================================================ */

(function () {

    var path = window.location.pathname;

    var inSubfolder =
        path.toLowerCase().includes('/fronted') ||
        path.toLowerCase().includes('/frontend');

    var root = inSubfolder ? '../' : '';
    var pg = inSubfolder ? '' : 'Frontend/fronted/';

    document.write(
        '<header class="site-header">' +

            '<div class="nav-inner">' +

                '<a href="' + root + 'index.html" class="brand-mark">' +
                    '<img src="' + root + 'assets/logo.png" ' +
                         'alt="NextStep AI" ' +
                         'class="brand-logo">' +
                    '<div class="brand-text">' +
                        'NextStep<span>AI</span>' +
                    '</div>' +
                '</a>' +

                '<nav class="main-nav">' +
                    '<ul>' +
                        '<li><a href="' + pg + 'about.html">عن المنصة</a></li>' +
                        '<li><a href="' + pg + 'universities.html">الجامعات</a></li>' +
                        '<li><a href="' + pg + 'quiz.html">الاختبار الذكي</a></li>' +
                        '<li><a href="' + root + 'index.html">الرئيسية</a></li>' +
                    '</ul>' +
                '</nav>' +

                '<div class="nav-actions">' +
                    '<a href="' + pg + 'signup.html" class="btn-signin">' +
                        'تسجيل دخول' +
                    '</a>' +
                '</div>' +

            '</div>' +

        '</header>' +

        '<div class="header-spacer"></div>'
    );


    function init() {

        var header = document.querySelector('header.site-header');
        var spacer = document.querySelector('.header-spacer');

        if (!header) return;


        /* ========================================================
           حساب الارتفاع الحقيقي للهيدر
           ======================================================== */

        function syncSpacerHeight() {

            if (!spacer) return;

            var height = header.offsetHeight;

            spacer.style.height = height + 'px';

            document.documentElement.style.setProperty(
                '--header-height',
                height + 'px'
            );
        }


        /* ========================================================
           حالة الهيدر
           ======================================================== */

        function onScroll() {

            if (window.scrollY > 20) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

        }


        /* ========================================================
           تشغيل الهيدر
           ======================================================== */

        requestAnimationFrame(function () {

            syncSpacerHeight();

            header.classList.add('ready');

            onScroll();

        });


        /* ========================================================
           تحديث الارتفاع
           ======================================================== */

        window.addEventListener(
            'resize',
            syncSpacerHeight,
            { passive: true }
        );


        window.addEventListener(
            'load',
            syncSpacerHeight
        );


        window.addEventListener(
            'scroll',
            onScroll,
            { passive: true }
        );

    }


    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            init
        );

    } else {

        init();

    }

})();