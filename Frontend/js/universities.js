/* =========================================================
   NEXTSTEP AI — UNIVERSITIES JS
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {

    const universities = [
        {
            name: "جامعة النجاح الوطنية",
            city: "نابلس",
            type: "حكومية",
            image: "https://images.unsplash.com/photo-1564981797816-1043664bf78d?auto=format&fit=crop&w=900&q=80",
            logo: "🎓"
        },

        {
            name: "جامعة بيرزيت",
            city: "رام الله",
            type: "خاصة",
            image: "https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=900&q=80",
            logo: "🌿"
        },

        {
            name: "جامعة الخليل",
            city: "الخليل",
            type: "خاصة",
            image: "https://images.unsplash.com/photo-1606761568499-6d2451b23c66?auto=format&fit=crop&w=900&q=80",
            logo: "U"
        },

        {
            name: "الجامعة العربية الأمريكية",
            city: "رام الله",
            type: "خاصة",
            image: "https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=900&q=80",
            logo: "AA"
        },

        {
            name: "جامعة بوليتكنك فلسطين",
            city: "الخليل",
            type: "تقنية",
            image: "https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=900&q=80",
            logo: "P"
        },

        {
            name: "جامعة القدس",
            city: "القدس",
            type: "حكومية",
            image: "https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=900&q=80",
            logo: "Q"
        },

        {
            name: "جامعة فلسطين التقنية",
            city: "طولكرم",
            type: "تقنية",
            image: "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=900&q=80",
            logo: "PT"
        },

        {
            name: "جامعة الاستقلال",
            city: "أريحا",
            type: "حكومية",
            image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=80",
            logo: "I"
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


            card.innerHTML = `

                <div class="uni-image">

                    <img
                        src="${uni.image}"
                        alt="${uni.name}"
                        loading="lazy">

                    <button
                        class="uni-heart"
                        type="button"
                        aria-label="إضافة للمفضلة">
                        ♡
                    </button>

                    <div class="uni-logo">
                        ${uni.logo}
                    </div>

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


            const detailsButton =
                card.querySelector(".uni-card-btn");


            detailsButton.addEventListener("click", () => {

                /*
                    غيّر الرابط هنا لاحقاً
                    حسب صفحة تفاصيل الجامعة
                */

                window.location.href =
                    `university-details.html?name=${encodeURIComponent(uni.name)}`;

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