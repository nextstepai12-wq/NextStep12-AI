/* =========================================================
   NEXTSTEP AI — UNIVERSITIES JS
   Database + Original Design Version (Merged)
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

    const ASSETS_BASE = "../assets/universities"; // Or whatever base is appropriate

    /* =====================================================
       CHECK ELEMENTS
       ===================================================== */

    if (!grid) {
        console.error("uniGrid غير موجود في الصفحة");
        return;
    }


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
        if (n === null || n === undefined || n === "") return "—";
        const num = Number(n);
        if (isNaN(num)) return String(n);
        if (num >= 1000) return Math.round(num / 1000) + "K+";
        return String(num);
    }

    function openUniModal(card) {
        if (!modalOverlay) return;

        const id = card.dataset.id;
        const name = card.dataset.name;
        const city = card.dataset.city;
        const students = card.dataset.students;
        const majors = card.dataset.majors;
        const deanships = card.dataset.deanships;
        const desc = card.dataset.desc;
        const coverImgSrc = card.querySelector('.uni-card-cover')?.src || "";
        const logoImgSrc = card.querySelector('.uni-logo-img')?.src || "";
        const fallbackText = card.querySelector('.uni-logo-fallback')?.textContent || "??";

        modalImage.onerror = null;
        modalImage.src = coverImgSrc;
        modalImage.alt = name;

        modalLogoFallback.textContent = fallbackText.trim();
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

        modalLogoImg.src = logoImgSrc;

        modalName.textContent = name;
        modalLocation.textContent = city;

        modalStudents.textContent = formatModalCount(students);
        modalMajors.textContent = majors ? majors : "—";
        modalDeanships.textContent = deanships ? deanships : "—";

        modalDesc.textContent = desc || "ما في نبذة متوفرة حالياً عن هاي الجامعة.";

        modalMoreBtn.href = `/universities/${id}`;

        modalOverlay.classList.add("open");
        document.body.style.overflow = "hidden";
    }

    function closeUniModal() {
        if (!modalOverlay) return;
        modalOverlay.classList.remove("open");
        document.body.style.overflow = "";
    }

    if (modalClose) {
        modalClose.addEventListener("click", closeUniModal);
    }

    if (modalOverlay) {
        modalOverlay.addEventListener("click", (event) => {
            if (event.target === modalOverlay) closeUniModal();
        });
    }

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") closeUniModal();
    });

    /* =====================================================
       CARD EVENT LISTENERS
       ===================================================== */
       
    function attachCardEvents() {
        const cards = grid.querySelectorAll(".uni-card");
        
        cards.forEach(card => {
            const coverImg = card.querySelector(".uni-card-cover");
            if (coverImg) {
                coverImg.addEventListener("error", function onCoverError() {
                    coverImg.removeEventListener("error", onCoverError);
                    coverImg.src = coverImg.dataset.fallback || "";
                });
            }

            const logoImg = card.querySelector(".uni-logo-img");
            const logoFallback = card.querySelector(".uni-logo-fallback");
            if (logoImg && logoFallback) {
                logoImg.addEventListener("load", () => {
                    logoImg.style.display = "block";
                    logoFallback.style.display = "none";
                });
                logoImg.addEventListener("error", function onLogoError() {
                    logoImg.removeEventListener("error", onLogoError);
                    logoImg.style.display = "none";
                    logoFallback.style.display = "flex";
                });
                // Trigger load/error check manually if image is already cached
                if (logoImg.complete) {
                    if (logoImg.naturalHeight === 0) {
                        logoImg.dispatchEvent(new Event('error'));
                    } else {
                        logoImg.dispatchEvent(new Event('load'));
                    }
                }
            }

            const heart = card.querySelector(".uni-heart");
            if (heart) {
                heart.addEventListener("click", (event) => {
                    event.stopPropagation();
                    heart.classList.toggle("liked");
                    heart.textContent = heart.classList.contains("liked") ? "♥" : "♡";
                });
            }

            const quickViewBtn = card.querySelector(".uni-quickview-btn");
            if (quickViewBtn) {
                quickViewBtn.addEventListener("click", (event) => {
                    event.stopPropagation();
                    openUniModal(card);
                });
            }
            
            const detailsButton = card.querySelector(".uni-card-btn");
            if (detailsButton) {
                detailsButton.addEventListener("click", (event) => {
                    event.stopPropagation();
                    window.location.href = `/universities/${card.dataset.id}`;
                });
            }
            
            const imageBox = card.querySelector(".uni-image");
            if (imageBox) {
                imageBox.addEventListener("click", (event) => {
                    event.stopPropagation();
                    window.location.href = `/universities/${card.dataset.id}`;
                });
            }
        });
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

        const cards = Array.from(grid.querySelectorAll(".uni-card"));
        let visibleCount = 0;

        cards.forEach(card => {
            const name = (card.dataset.name || "").toLowerCase();
            const city = (card.dataset.city || "").toLowerCase();
            const type = (card.dataset.type || "").toLowerCase();

            const filterMatch =
                currentFilter === "all" ||
                type === currentFilter.toLowerCase();

            const searchMatch =
                !search ||
                name.includes(search) ||
                city.includes(search);

            if (filterMatch && searchMatch) {
                card.style.display = "";
                card.style.animationDelay = `${visibleCount * 70}ms`;
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        if (count) {
            count.textContent = visibleCount;
        }

        updateDots();
        handleEmptyState(visibleCount);
    }


    /* =====================================================
       EMPTY STATE
       ===================================================== */

    function handleEmptyState(visibleCount) {
        let emptyDiv = grid.querySelector(".empty-state-search");

        if (visibleCount === 0) {
            if (!emptyDiv) {
                emptyDiv = document.createElement("div");
                emptyDiv.className = "empty-state empty-state-search";
                emptyDiv.innerHTML = `
                    <div>⌕</div>
                    <h3>ما لقينا جامعة بهذا الاسم</h3>
                    <p>جربي البحث باسم مختلف.</p>
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
        searchButton.addEventListener("click", applyFilters);
    }


    /* =====================================================
       LIVE SEARCH
       ===================================================== */

    if (searchInput) {
        searchInput.addEventListener("input", () => {
            clearTimeout(searchInput.searchTimer);
            searchInput.searchTimer = setTimeout(applyFilters, 250);
        });

        searchInput.addEventListener("keydown", event => {
            if (event.key === "Enter") {
                applyFilters();
            }
        });
    }


    /* =====================================================
       CAROUSEL
       ===================================================== */

    function getVisibleCards() {
        const width = window.innerWidth;
        if (width <= 600) return 1;
        if (width <= 850) return 2;
        if (width <= 1100) return 3;
        return 4;
    }


    function getScrollAmount() {
        const firstCard = grid.querySelector(".uni-card");
        if (!firstCard) return 300;

        const style = window.getComputedStyle(grid);
        const gap = parseFloat(style.gap) || 16;
        return firstCard.offsetWidth + gap;
    }


    /* =====================================================
       NEXT
       ===================================================== */

    if (nextButton) {
        nextButton.addEventListener("click", () => {
            grid.scrollBy({
                left: -getScrollAmount(),
                behavior: "smooth"
            });
        });
    }

    /* =====================================================
       PREVIOUS
       ===================================================== */

    if (prevButton) {
        prevButton.addEventListener("click", () => {
            grid.scrollBy({
                left: getScrollAmount(),
                behavior: "smooth"
            });
        });
    }

    /* =====================================================
       DOTS
       ===================================================== */

    function updateDots() {
        if (!dots) return;

        dots.innerHTML = "";

        const cards = Array.from(grid.querySelectorAll(".uni-card"))
            .filter(card => card.style.display !== "none");

        if (!cards.length) return;

        const visibleCards = getVisibleCards();
        const amount = Math.max(1, Math.ceil(cards.length / visibleCards));

        for (let i = 0; i < amount; i++) {
            const dot = document.createElement("span");
            dot.className = "carousel-dot";
            if (i === 0) dot.classList.add("active");

            dot.addEventListener("click", () => {
                const scrollPosition = i * getScrollAmount() * visibleCards;
                grid.scrollTo({
                    left: -scrollPosition,
                    behavior: "smooth"
                });
            });
            dots.appendChild(dot);
        }
    }

    /* =====================================================
       UPDATE ACTIVE DOT
       ===================================================== */

    grid.addEventListener("scroll", () => {
        if (!dots || !dots.children.length) return;

        const max = Math.abs(grid.scrollWidth - grid.clientWidth);
        if (max <= 0) return;

        const current = Math.abs(grid.scrollLeft);
        const progress = current / max;
        const dotCount = dots.children.length;
        const activeIndex = Math.min(
            dotCount - 1,
            Math.round(progress * (dotCount - 1))
        );

        Array.from(dots.children).forEach((dot, index) => {
            dot.classList.toggle("active", index === activeIndex);
        });
    });

    /* =====================================================
       FAQ
       ===================================================== */

    document.querySelectorAll(".faq-question").forEach(button => {
        button.addEventListener("click", () => {
            const item = button.closest(".faq-item");
            const answer = item.querySelector(".faq-answer");

            document.querySelectorAll(".faq-item.active").forEach(openItem => {
                if (openItem !== item) {
                    openItem.classList.remove("active");
                    const openAnswer = openItem.querySelector(".faq-answer");
                    if (openAnswer) openAnswer.style.maxHeight = null;
                }
            });

            item.classList.toggle("active");
            if (item.classList.contains("active")) {
                answer.style.maxHeight = answer.scrollHeight + "px";
            } else {
                answer.style.maxHeight = null;
            }
        });
    });

    /* =====================================================
       FILTER ARROWS
       ===================================================== */

    if (filterPrev && filterContainer) {
        filterPrev.addEventListener("click", () => {
            filterContainer.scrollBy({ left: 220, behavior: "smooth" });
        });
    }

    if (filterNext && filterContainer) {
        filterNext.addEventListener("click", () => {
            filterContainer.scrollBy({ left: -220, behavior: "smooth" });
        });
    }

    /* =====================================================
       AUTO CAROUSEL
       ===================================================== */

    let autoScroll = null;

    function startAutoScroll() {
        stopAutoScroll();
        autoScroll = setInterval(() => {
            const max = Math.abs(grid.scrollWidth - grid.clientWidth);
            if (max <= 0) return;

            const current = Math.abs(grid.scrollLeft);
            if (current >= max - 10) {
                grid.scrollTo({ left: 0, behavior: "smooth" });
            } else {
                grid.scrollBy({ left: -getScrollAmount(), behavior: "smooth" });
            }
        }, 4500);
    }

    function stopAutoScroll() {
        if (autoScroll) {
            clearInterval(autoScroll);
            autoScroll = null;
        }
    }

    grid.addEventListener("mouseenter", stopAutoScroll);
    grid.addEventListener("mouseleave", startAutoScroll);


    /* =====================================================
       INITIALIZE
       ===================================================== */

    attachCardEvents();
    applyFilters();
    updateDots();
    startAutoScroll();

    window.addEventListener("resize", () => {
        updateDots();
    });

});