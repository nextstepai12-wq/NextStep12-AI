/* =========================================================
   NEXTSTEP AI — UNIVERSITIES JS
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {

    const universities = [
        {
            id: 1,
            name: "الكلية الجامعية للعلوم التطبيقية ",
            city: "غزة",
            type: "حكومية",
            image: "https://images.unsplash.com/photo-1564981797816-1043664bf78d?auto=format&fit=crop&w=900&q=80",
            logo: "🎓",
            description: "جامعة النجاح الوطنية من أعرق وأكبر الجامعات الفلسطينية، تأسست سنة 1918 وتضم عشرات الكليات والبرامج الأكاديمية على مستوى البكالوريوس والدراسات العليا.",
            students_count: 22000,
            majors_count: 74,
            deanships_count: 12
        },

        {
            id: 2,
            name: "جامعة بيرزيت",
            city: "رام الله",
            type: "خاصة",
            image: "https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=900&q=80",
            logo: "🌿",
            description: "جامعة بيرزيت من الجامعات الفلسطينية الرائدة بالبحث العلمي، وبتقدم برامج متنوعة بالعلوم والآداب والهندسة وإدارة الأعمال.",
            students_count: 13000,
            majors_count: 58,
            deanships_count: 9
        },

        {
            id: 3,
            name: "جامعة الخليل",
            city: "الخليل",
            type: "خاصة",
            image: "https://images.unsplash.com/photo-1606761568499-6d2451b23c66?auto=format&fit=crop&w=900&q=80",
            logo: "U",
            description: "جامعة الخليل بتخدم منطقة جنوب الضفة الغربية، وبتقدم برامج أكاديمية بمجالات العلوم الإنسانية والتطبيقية والتربوية.",
            students_count: 9500,
            majors_count: 42,
            deanships_count: 8
        },

        {
            id: 4,
            name: "الجامعة العربية الأمريكية",
            city: "رام الله",
            type: "خاصة",
            image: "https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=900&q=80",
            logo: "AA",
            description: "الجامعة العربية الأمريكية جامعة خاصة حديثة، معروفة ببرامج الطب والهندسة وإدارة الأعمال وشراكاتها الدولية.",
            students_count: 11000,
            majors_count: 51,
            deanships_count: 10
        },

        {
            id: 5,
            name: "جامعة بوليتكنك فلسطين",
            city: "الخليل",
            type: "تقنية",
            image: "https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=900&q=80",
            logo: "P",
            description: "جامعة بوليتكنك فلسطين متخصصة بالتعليم التقني والهندسي، وبتركز على ربط التعليم بسوق العمل عبر برامج تطبيقية.",
            students_count: 7000,
            majors_count: 35,
            deanships_count: 6
        },

        {
            id: 6,
            name: "جامعة القدس",
            city: "القدس",
            type: "حكومية",
            image: "https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=900&q=80",
            logo: "Q",
            description: "جامعة القدس من الجامعات الفلسطينية العريقة، وبتضم كليات بمجالات الطب والعلوم والآداب والحقوق.",
            students_count: 12500,
            majors_count: 60,
            deanships_count: 11
        },

        {
            id: 7,
            name: "جامعة فلسطين التقنية",
            city: "طولكرم",
            type: "تقنية",
            image: "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=900&q=80",
            logo: "PT",
            description: "جامعة فلسطين التقنية (خضوري) بتركز على العلوم الزراعية والهندسية والتقنية، وبتخدم منطقة شمال الضفة الغربية.",
            students_count: 8000,
            majors_count: 38,
            deanships_count: 7
        },

        {
            id: 8,
            name: "جامعة الاستقلال",
            city: "أريحا",
            type: "حكومية",
            image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=80",
            logo: "I",
            description: "جامعة الاستقلال جامعة حكومية حديثة النشأة، بتقدم برامج بمجالات الأمن والسلامة والعلوم الإدارية والتقنية.",
            students_count: 4500,
            majors_count: 22,
            deanships_count: 5
        }
    ];


    const grid = document.getElementById("uniGrid");
    const count = document.getElementById("resultsCount");

    const searchInput =
        document.getElementById("uniSearchInput");

    const searchButton =
        document.getElementById("uniSearchBtn");

    const filterContainer =
        document.getElementById("uniFilterChips");

    const prevButton =
        document.getElementById("carouselPrev");

    const nextButton =
        document.getElementById("carouselNext");

    const dots =
        document.getElementById("carouselDots");


    let currentFilter = "all";
    let currentData = [...universities];

    const ASSETS_BASE = "../assets/universities";


    /* =====================================================
       QUICK VIEW MODAL
       ===================================================== */

    const modalOverlay = document.getElementById("uniModalOverlay");
    const modalClose = document.getElementById("uniModalClose");
    const modalImage = document.getElementById("uniModalImage");
    const modalLogoImg = document.getElementById("uniModalLogoImg");
    const modalLogoFallback = document.getElementById("uniModalLogoFallback");
    const modalName = document.getElementById("uniModalName");
    const modalLocation = document.getElementById("uniModalLocation");
    const modalStudents = document.getElementById("uniModalStudents");
    const modalMajors = document.getElementById("uniModalMajors");
    const modalDeanships = document.getElementById("uniModalDeanships");
    const modalDesc = document.getElementById("uniModalDesc");
    const modalMoreBtn = document.getElementById("uniModalMoreBtn");

    function formatModalCount(n) {
        if (n === null || n === undefined) return "—";
        if (n >= 1000) return Math.round(n / 1000) + "K+";
        return String(n);
    }

    function openUniModal(uni) {

        modalImage.onerror = null;
        modalImage.src = `${ASSETS_BASE}/${uni.id}/cover.jpg`;
        modalImage.alt = uni.name;

        modalImage.onerror = () => {
            modalImage.onerror = null;
            modalImage.src = uni.image;
        };

        modalLogoFallback.textContent = uni.logo;
        modalLogoImg.style.display = "none";
        modalLogoFallback.style.display = "flex";

        modalLogoImg.onload = () => {
            modalLogoImg.style.display = "block";
            modalLogoFallback.style.display = "none";
        };

        modalLogoImg.onerror = () => {
            modalLogoImg.style.display = "none";
            modalLogoFallback.style.display = "flex";
        };

        modalLogoImg.src = `${ASSETS_BASE}/${uni.id}/logo.png`;

        modalName.textContent = uni.name;
        modalLocation.textContent = uni.city;

        modalStudents.textContent = formatModalCount(uni.students_count);
        modalMajors.textContent = uni.majors_count ?? "—";
        modalDeanships.textContent = uni.deanships_count ?? "—";

        modalDesc.textContent =
            uni.description || "ما في نبذة متوفرة حالياً عن هاي الجامعة.";

        modalMoreBtn.href =
            `university-details.html?id=${uni.id}`;

        modalOverlay.classList.add("open");
        document.body.style.overflow = "hidden";
    }

    function closeUniModal() {
        modalOverlay.classList.remove("open");
        document.body.style.overflow = "";
    }

    modalClose.addEventListener("click", closeUniModal);

    modalOverlay.addEventListener("click", (event) => {
        if (event.target === modalOverlay) closeUniModal();
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") closeUniModal();
    });


    /* =====================================================
       RENDER
       ===================================================== */

    function renderUniversities(data) {

        currentData = data;

        grid.innerHTML = "";

        count.textContent = data.length;


        if (!data.length) {

            grid.innerHTML = `
                <div class="empty-state">
                    <div>⌕</div>
                    <h3>ما لقينا جامعة بهذا الاسم</h3>
                    <p>جربي البحث باسم مختلف.</p>
                </div>
            `;

            dots.innerHTML = "";

            return;
        }


        data.forEach((uni, index) => {

            const card = document.createElement("article");

            card.className = "uni-card";

            card.style.animationDelay =
                `${index * 70}ms`;


            const coverPath =
                `${ASSETS_BASE}/${uni.id}/cover.jpg`;

            const logoPath =
                `${ASSETS_BASE}/${uni.id}/logo.png`;


            card.innerHTML = `

                <div class="uni-image">

                    <img
                        class="uni-card-cover"
                        src="${coverPath}"
                        data-fallback="${uni.image}"
                        alt="${uni.name}"
                        loading="lazy">

                    <button
                        class="uni-heart"
                        type="button"
                        aria-label="إضافة للمفضلة">
                        ♡
                    </button>

                    <button
                        class="uni-quickview-btn"
                        type="button"
                        aria-label="نظرة سريعة على ${uni.name}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        نظرة سريعة
                    </button>

                </div>


                <div class="uni-logo">
                    <img
                        class="uni-logo-img"
                        src="${logoPath}"
                        alt=""
                        style="display:none;">
                    <span class="uni-logo-fallback">
                        ${uni.logo}
                    </span>
                </div>


                <div class="uni-card-body">

                    <h3>${uni.name}</h3>

                    <span class="uni-location">
                        ${uni.city}
                    </span>

                    <button
                        class="uni-card-btn"
                        type="button">
                        عرض الجامعة ←
                    </button>

                </div>
            `;


            /* الصورة المحلية أولاً، وإذا مو موجودة نرجع
               تلقائياً لصورة الاحتياط بدون ما تنكسر الواجهة */

            const coverImg =
                card.querySelector(".uni-card-cover");

            coverImg.addEventListener("error", function onCoverError() {

                coverImg.removeEventListener("error", onCoverError);

                coverImg.src =
                    coverImg.dataset.fallback;

            });


            /* نفس المنطق للوجو: لو logo.png مو موجود
               منرجع لحرف/إيموجي الاحتياط */

            const logoImg =
                card.querySelector(".uni-logo-img");

            const logoFallback =
                card.querySelector(".uni-logo-fallback");

            logoImg.addEventListener("load", () => {
                logoImg.style.display = "block";
                logoFallback.style.display = "none";
            });

            logoImg.addEventListener("error", function onLogoError() {
                logoImg.removeEventListener("error", onLogoError);
                logoImg.style.display = "none";
                logoFallback.style.display = "flex";
            });


            const heart =
                card.querySelector(".uni-heart");


            heart.addEventListener("click", (event) => {

                event.stopPropagation();

                heart.classList.toggle("liked");

                heart.textContent =
                    heart.classList.contains("liked")
                        ? "♥"
                        : "♡";

            });


            const quickViewBtn =
                card.querySelector(".uni-quickview-btn");

            quickViewBtn.addEventListener("click", (event) => {
                event.stopPropagation();
                openUniModal(uni);
            });


            const detailsButton =
                card.querySelector(".uni-card-btn");


            detailsButton.addEventListener("click", () => {

                window.location.href =
                    `university-details.html?id=${uni.id}`;

            });


            /* الضغط على الصورة نفسها بيوديها لصفحة
               التفاصيل مباشرة (زي زر "عرض الجامعة") */

            const imageBox =
                card.querySelector(".uni-image");

            imageBox.addEventListener("click", () => {

                window.location.href =
                    `university-details.html?id=${uni.id}`;

            });


            grid.appendChild(card);

        });


        updateDots();
    }


    /* =====================================================
       FILTER
       ===================================================== */

    filterContainer
        .querySelectorAll(".filter-chip")
        .forEach(button => {

            button.addEventListener("click", () => {

                filterContainer
                    .querySelectorAll(".filter-chip")
                    .forEach(btn =>
                        btn.classList.remove("active")
                    );

                button.classList.add("active");

                currentFilter =
                    button.dataset.filter;

                applyFilters();

            });

        });


    function applyFilters() {

        const search =
            searchInput.value
                .trim()
                .toLowerCase();


        let filtered = universities.filter(uni => {

            const filterMatch =
                currentFilter === "all" ||
                uni.type === currentFilter;

            const searchMatch =
                !search ||
                uni.name.toLowerCase().includes(search) ||
                uni.city.toLowerCase().includes(search);

            return filterMatch && searchMatch;

        });


        renderUniversities(filtered);
    }


    /* =====================================================
       SEARCH
       ===================================================== */

    searchButton.addEventListener(
        "click",
        applyFilters
    );


    searchInput.addEventListener(
        "input",
        () => {

            clearTimeout(searchInput.searchTimer);

            searchInput.searchTimer =
                setTimeout(applyFilters, 250);

        }
    );


    searchInput.addEventListener(
        "keydown",
        event => {

            if (event.key === "Enter") {
                applyFilters();
            }

        }
    );


    /* =====================================================
       CAROUSEL
       ===================================================== */

    function getScrollAmount() {

        const firstCard =
            grid.querySelector(".uni-card");

        if (!firstCard) return 300;

        const gap = 16;

        return firstCard.offsetWidth + gap;

    }


    nextButton.addEventListener("click", () => {

        grid.scrollBy({
            left: -getScrollAmount(),
            behavior: "smooth"
        });

    });


    prevButton.addEventListener("click", () => {

        grid.scrollBy({
            left: getScrollAmount(),
            behavior: "smooth"
        });

    });


    /* =====================================================
       DOTS
       ===================================================== */

    function updateDots() {

        dots.innerHTML = "";

        const cards =
            grid.querySelectorAll(".uni-card");

        if (!cards.length) return;


        const amount =
            Math.max(
                1,
                Math.ceil(
                    cards.length /
                    getVisibleCards()
                )
            );


        for (let i = 0; i < amount; i++) {

            const dot =
                document.createElement("span");

            dot.className =
                "carousel-dot";

            if (i === 0) {
                dot.classList.add("active");
            }

            dot.addEventListener("click", () => {

                grid.scrollTo({
                    left:
                        i *
                        getScrollAmount() *
                        getVisibleCards(),

                    behavior: "smooth"
                });

            });

            dots.appendChild(dot);
        }

    }


    function getVisibleCards() {

        const width =
            window.innerWidth;

        if (width <= 600) return 1;

        if (width <= 850) return 2;

        if (width <= 1100) return 3;

        return 4;
    }


    grid.addEventListener(
        "scroll",
        () => {

            const max =
                grid.scrollWidth -
                grid.clientWidth;

            if (max <= 0) return;

            const progress =
                Math.abs(grid.scrollLeft) / max;

            const dotCount =
                dots.children.length;

            const activeIndex =
                Math.min(
                    dotCount - 1,
                    Math.round(
                        progress *
                        (dotCount - 1)
                    )
                );


            [...dots.children]
                .forEach((dot, index) => {

                    dot.classList.toggle(
                        "active",
                        index === activeIndex
                    );

                });

        }
    );


    /* =====================================================
       FAQ
       ===================================================== */

    document
        .querySelectorAll(".faq-question")
        .forEach(button => {

            button.addEventListener("click", () => {

                const item =
                    button.closest(".faq-item");

                const answer =
                    item.querySelector(".faq-answer");


                document
                    .querySelectorAll(".faq-item.active")
                    .forEach(openItem => {

                        if (openItem !== item) {

                            openItem.classList.remove("active");

                            openItem
                                .querySelector(".faq-answer")
                                .style.maxHeight = null;

                        }

                    });


                item.classList.toggle("active");


                if (item.classList.contains("active")) {

                    answer.style.maxHeight =
                        answer.scrollHeight + "px";

                } else {

                    answer.style.maxHeight = null;

                }

            });

        });


    /* =====================================================
       FILTER ARROWS
       ===================================================== */

    document
        .getElementById("filterPrev")
        .addEventListener("click", () => {

            filterContainer.scrollBy({
                left: 220,
                behavior: "smooth"
            });

        });


    document
        .getElementById("filterNext")
        .addEventListener("click", () => {

            filterContainer.scrollBy({
                left: -220,
                behavior: "smooth"
            });

        });


    /* =====================================================
       AUTO CAROUSEL
       ===================================================== */

    let autoScroll;

    function startAutoScroll() {

        autoScroll =
            setInterval(() => {

                const max =
                    grid.scrollWidth -
                    grid.clientWidth;

                if (Math.abs(grid.scrollLeft) >= max - 10) {

                    grid.scrollTo({
                        left: 0,
                        behavior: "smooth"
                    });

                } else {

                    grid.scrollBy({
                        left: -getScrollAmount(),
                        behavior: "smooth"
                    });

                }

            }, 4500);

    }


    function stopAutoScroll() {
        clearInterval(autoScroll);
    }


    grid.addEventListener(
        "mouseenter",
        stopAutoScroll
    );

    
    grid.addEventListener(
        "mouseleave",
        startAutoScroll
    );


    /* =====================================================
       INITIALIZE
       ===================================================== */

    renderUniversities(universities);

    startAutoScroll();


    window.addEventListener(
        "resize",
        () => updateDots()
    );

});