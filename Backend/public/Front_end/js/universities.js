/* =========================================================
   NEXTSTEP AI — UNIVERSITIES JS
   Database + Original Design Version
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
       ELEMENTS
       ===================================================== */

    const grid = document.getElementById("uniGrid");
    const count = document.getElementById("resultsCount");

    const searchInput = document.getElementById("uniSearchInput");
    const searchButton = document.getElementById("uniSearchBtn");

    const filterContainer = document.getElementById("uniFilterChips");

    const prevButton = document.getElementById("carouselPrev");
    const nextButton = document.getElementById("carouselNext");

    const dots = document.getElementById("carouselDots");

    const filterPrev = document.getElementById("filterPrev");
    const filterNext = document.getElementById("filterNext");


    /* =====================================================
       CHECK ELEMENTS
       ===================================================== */

    if (!grid) {
        console.error("uniGrid غير موجود في الصفحة");
        return;
    }


    /* =====================================================
       FILTER
       ===================================================== */

    let currentFilter = "all";


    if (filterContainer) {

        filterContainer
            .querySelectorAll(".filter-chip")
            .forEach(button => {

                button.addEventListener("click", () => {

                    filterContainer
                        .querySelectorAll(".filter-chip")
                        .forEach(btn => {
                            btn.classList.remove("active");
                        });

                    button.classList.add("active");

                    currentFilter = button.dataset.filter || "all";

                    applyFilters();

                });

            });

    }


    /* =====================================================
       SEARCH + FILTER
       ===================================================== */

    function applyFilters() {

        const search = searchInput
            ? searchInput.value.trim().toLowerCase()
            : "";

        const cards = Array.from(
            grid.querySelectorAll(".uni-card")
        );

        let visibleCount = 0;


        cards.forEach(card => {

            const name = (
                card.dataset.name || ""
            ).toLowerCase();

            const city = (
                card.dataset.city || ""
            ).toLowerCase();

            const type = (
                card.dataset.type || ""
            ).toLowerCase();


            const filterMatch =
                currentFilter === "all" ||
                type === currentFilter.toLowerCase();


            const searchMatch =
                !search ||
                name.includes(search) ||
                city.includes(search);


            if (filterMatch && searchMatch) {

                card.style.display = "";

                card.style.animationDelay =
                    `${visibleCount * 70}ms`;

                visibleCount++;

            } else {

                card.style.display = "none";

            }

        });


        /* تحديث عدد الجامعات */

        if (count) {
            count.textContent = visibleCount;
        }


        /* تحديث السلايدر */

        updateDots();


        /* حالة عدم وجود نتائج */

        handleEmptyState(visibleCount);

    }


    /* =====================================================
       EMPTY STATE
       ===================================================== */

    function handleEmptyState(visibleCount) {

        let emptyDiv =
            grid.querySelector(".empty-state-search");


        if (visibleCount === 0) {

            if (!emptyDiv) {

                emptyDiv =
                    document.createElement("div");

                emptyDiv.className =
                    "empty-state empty-state-search";


                emptyDiv.innerHTML = `
                    <div>⌕</div>

                    <h3>
                        ما لقينا جامعة بهذا الاسم
                    </h3>

                    <p>
                        جربي البحث باسم مختلف.
                    </p>
                `;


                grid.appendChild(emptyDiv);

            }

        } else {

            if (emptyDiv) {
                emptyDiv.remove();
            }

        }

    }


    /* =====================================================
       SEARCH BUTTON
       ===================================================== */

    if (searchButton) {

        searchButton.addEventListener(
            "click",
            applyFilters
        );

    }


    /* =====================================================
       LIVE SEARCH
       ===================================================== */

    if (searchInput) {

        searchInput.addEventListener(
            "input",
            () => {

                clearTimeout(
                    searchInput.searchTimer
                );

                searchInput.searchTimer =
                    setTimeout(
                        applyFilters,
                        250
                    );

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

    }


    /* =====================================================
       UNIVERSITY BUTTON
       ===================================================== */

    grid.addEventListener(
        "click",
        event => {

            const detailsButton =
                event.target.closest(
                    ".uni-view-btn, .uni-card-btn"
                );


            if (!detailsButton) {
                return;
            }


            const card =
                detailsButton.closest(".uni-card");


            if (!card) {
                return;
            }


            const universityId =
                card.dataset.id;


            if (!universityId) {
                console.error(
                    "لم يتم العثور على ID الجامعة"
                );
                return;
            }


            /*
             * صفحة تفاصيل الجامعة
             */

            window.location.href =
                `/universities/${universityId}`;

        }
    );


    /* =====================================================
       CAROUSEL
       ===================================================== */

    function getVisibleCards() {

        const width =
            window.innerWidth;


        if (width <= 600) {
            return 1;
        }

        if (width <= 850) {
            return 2;
        }

        if (width <= 1100) {
            return 3;
        }

        return 4;

    }


    function getScrollAmount() {

        const firstCard =
            grid.querySelector(".uni-card");


        if (!firstCard) {
            return 300;
        }


        const style =
            window.getComputedStyle(grid);


        const gap =
            parseFloat(style.gap) || 16;


        return firstCard.offsetWidth + gap;

    }


    /* =====================================================
       NEXT
       ===================================================== */

    if (nextButton) {

        nextButton.addEventListener(
            "click",
            () => {

                grid.scrollBy({
                    left: -getScrollAmount(),
                    behavior: "smooth"
                });

            }
        );

    }


    /* =====================================================
       PREVIOUS
       ===================================================== */

    if (prevButton) {

        prevButton.addEventListener(
            "click",
            () => {

                grid.scrollBy({
                    left: getScrollAmount(),
                    behavior: "smooth"
                });

            }
        );

    }


    /* =====================================================
       DOTS
       ===================================================== */

    function updateDots() {

        if (!dots) {
            return;
        }


        dots.innerHTML = "";


        const cards =
            Array.from(
                grid.querySelectorAll(".uni-card")
            )
            .filter(
                card =>
                    card.style.display !== "none"
            );


        if (!cards.length) {
            return;
        }


        const visibleCards =
            getVisibleCards();


        const amount =
            Math.max(
                1,
                Math.ceil(
                    cards.length /
                    visibleCards
                )
            );


        for (
            let i = 0;
            i < amount;
            i++
        ) {

            const dot =
                document.createElement("span");


            dot.className =
                "carousel-dot";


            if (i === 0) {
                dot.classList.add("active");
            }


            dot.addEventListener(
                "click",
                () => {

                    const scrollPosition =
                        i *
                        getScrollAmount() *
                        visibleCards;


                    grid.scrollTo({
                        left: -scrollPosition,
                        behavior: "smooth"
                    });

                }
            );


            dots.appendChild(dot);

        }

    }


    /* =====================================================
       UPDATE ACTIVE DOT
       ===================================================== */

    grid.addEventListener(
        "scroll",
        () => {

            if (!dots || !dots.children.length) {
                return;
            }


            const max =
                Math.abs(
                    grid.scrollWidth -
                    grid.clientWidth
                );


            if (max <= 0) {
                return;
            }


            const current =
                Math.abs(grid.scrollLeft);


            const progress =
                current / max;


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


            Array.from(
                dots.children
            ).forEach(
                (dot, index) => {

                    dot.classList.toggle(
                        "active",
                        index === activeIndex
                    );

                }
            );

        }
    );


    /* =====================================================
       FAQ
       ===================================================== */

    document
        .querySelectorAll(".faq-question")
        .forEach(button => {

            button.addEventListener(
                "click",
                () => {

                    const item =
                        button.closest(".faq-item");


                    const answer =
                        item.querySelector(
                            ".faq-answer"
                        );


                    document
                        .querySelectorAll(
                            ".faq-item.active"
                        )
                        .forEach(
                            openItem => {

                                if (
                                    openItem !== item
                                ) {

                                    openItem.classList
                                        .remove("active");


                                    const openAnswer =
                                        openItem.querySelector(
                                            ".faq-answer"
                                        );


                                    if (openAnswer) {

                                        openAnswer.style
                                            .maxHeight = null;

                                    }

                                }

                            }
                        );


                    item.classList.toggle(
                        "active"
                    );


                    if (
                        item.classList.contains(
                            "active"
                        )
                    ) {

                        answer.style.maxHeight =
                            answer.scrollHeight +
                            "px";

                    } else {

                        answer.style.maxHeight =
                            null;

                    }

                }
            );

        });


    /* =====================================================
       FILTER ARROWS
       ===================================================== */

    if (filterPrev && filterContainer) {

        filterPrev.addEventListener(
            "click",
            () => {

                filterContainer.scrollBy({
                    left: 220,
                    behavior: "smooth"
                });

            }
        );

    }


    if (filterNext && filterContainer) {

        filterNext.addEventListener(
            "click",
            () => {

                filterContainer.scrollBy({
                    left: -220,
                    behavior: "smooth"
                });

            }
        );

    }


    /* =====================================================
       AUTO CAROUSEL
       ===================================================== */

    let autoScroll = null;


    function startAutoScroll() {

        stopAutoScroll();


        autoScroll =
            setInterval(
                () => {

                    const max =
                        Math.abs(
                            grid.scrollWidth -
                            grid.clientWidth
                        );


                    if (max <= 0) {
                        return;
                    }


                    const current =
                        Math.abs(
                            grid.scrollLeft
                        );


                    if (
                        current >= max - 10
                    ) {

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

                },
                4500
            );

    }


    function stopAutoScroll() {

        if (autoScroll) {

            clearInterval(autoScroll);

            autoScroll = null;

        }

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

    applyFilters();

    updateDots();

    startAutoScroll();


    window.addEventListener(
        "resize",
        () => {

            updateDots();

        }
    );

});