<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دليل الجامعات — NextStep AI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('Front_end/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('Front_end/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('Front_end/css/universities.css') }}">
    <link rel="stylesheet" href="{{ asset('Front_end/css/footer.css') }}">
</head>

<body>

    <script src="{{ asset('Front_end/js/header-index.js') }}" defer></script>

    <!-- ================= HERO ================= -->
    <section class="uni-hero">
        <div class="hero-grid"></div>
        <div class="hero-glow glow-one"></div>
        <div class="hero-glow glow-two"></div>

        <div class="hero-map">
            <svg viewBox="0 0 700 520" preserveAspectRatio="xMidYMid meet">
                <path class="map-outline" d="M355 38 C330 65 330 95 340 120 C350 145 325 160 330 185 C335 215 315 235 320 260 C325 285 310 310 320 340 C330 370 315 395 330 420 C345 445 335 470 355 495" />
                <path class="journey-path" d="M335 440 C365 410 350 375 385 350 C415 325 400 290 430 265 C455 240 445 210 475 185 C500 160 485 130 515 105 C535 88 550 70 575 55" />
                <circle class="map-point" cx="335" cy="440" r="6"/>
                <circle class="map-point" cx="385" cy="350" r="6"/>
                <circle class="map-point" cx="430" cy="265" r="6"/>
                <circle class="map-point" cx="475" cy="185" r="6"/>
                <circle class="map-point" cx="515" cy="105" r="6"/>
                <circle class="destination-pulse" cx="575" cy="55" r="12"/>
                <circle class="destination" cx="575" cy="55" r="7"/>
            </svg>

            <span class="map-label label-tulkarm">طولكرم</span>
            <span class="map-label label-hebron">الخليل</span>
            <span class="map-label label-jerusalem">القدس</span>
            <span class="map-label label-ramallah">رام الله</span>
            <span class="map-label label-nablus">جنين</span>

            <div class="destination-label">
                <span>خطوتك القادمة</span>
                <i></i>
            </div>
        </div>

        <div class="uni-hero-content">
            <div class="uni-eyebrow">
                <span class="eyebrow-dot"></span>
                اكتشف مستقبلك 
                <span class="spark">✦</span>
            </div>

            <h1>اكتشف <span>جامعتك القادمة</span></h1>
            
            <p>
                استكشف الجامعات والتخصصات، قارني خياراتك،
                وخذ أول خطوة نحو مستقبلك مع
                <strong>NextStep AI</strong>.
            </p>

            <div class="search-hero-box">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="M21 21l-4.3-4.3"></path>
                </svg>
                <input type="search" id="uniSearchInput" placeholder="ابحث عن جامعة..." autocomplete="off">
                <button id="uniSearchBtn">بحث</button>
            </div>

            <div class="hero-mini-stats">
                <div class="hero-stat">
                    <strong>{{ $universities->count() }}+</strong>
                    <span>جامعة وكلية</span>
                </div>
                <div class="stat-line"></div>
                <div class="hero-stat">
                    <strong>500+</strong>
                    <span>تخصص جامعي</span>
                </div>
                <div class="stat-line"></div>
                <div class="hero-stat">
                    <strong>NextStep</strong>
                    <span>خطوتك نحو المستقبل</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="uni-main">
        <section class="universities-section">
            
            <div class="section-head">
                <div>
                    <span class="section-kicker">دليل الجامعات</span>
                    <h2>اختار المكان الذي <span>يصنع خطوتك القادمة</span></h2>
                    <p>استكشف الجامعات المتاحة وتعرف على أهم المعلومات عنها.</p>
                </div>
                <div class="results-count-box">
                    <strong id="resultsCount">{{ $universities->count() }}</strong>
                    <span>جامعة متاحة</span>
                </div>
            </div>

            <!-- FILTERS -->
            <div class="uni-filter-wrapper">
                <button class="filter-arrow filter-prev" id="filterPrev">‹</button>
                <div class="uni-filter-chips" id="uniFilterChips">
                    <!-- إذا كان عندك جدول فلاتر في الداتا بيز ضع هنا foreach ثاني -->
                </div>
                <button class="filter-arrow filter-next" id="filterNext">›</button>
            </div>

            <!-- CAROUSEL -->
            <div class="uni-carousel-wrapper">
                <button class="carousel-btn carousel-prev" id="carouselPrev"><span>←</span></button>
                
<div class="uni-carousel" id="uniGrid">

    @forelse($universities as $uni)

        <div class="uni-card"
             data-id="{{ $uni->id }}"
             data-name="{{ $uni->name }}"
             data-city="{{ $uni->location ?? '' }}"
             data-type="{{ $uni->type ?? '' }}">

            {{-- ================= صورة غلاف الجامعة ================= --}}
            <div class="uni-card-cover">

                @if(!empty($uni->cover_image))
                    <img
                        src="{{ $uni->cover_image }}"
                        alt="{{ $uni->name }}"
                        loading="lazy"
                    >
                @else
                    <div class="uni-card-cover-placeholder">
                        <span>لا توجد صورة</span>
                    </div>
                @endif

            </div>


            {{-- ================= معلومات الجامعة ================= --}}
            <div class="uni-card-body">

                {{-- شعار الجامعة --}}
                <div class="uni-card-logo">

                    @if(!empty($uni->logo))

                        <img
                            src="{{ $uni->logo }}"
                            alt="شعار {{ $uni->name }}"
                            loading="lazy"
                        >

                    @else

                        <span>
                            {{ mb_substr($uni->name, 0, 2) }}
                        </span>

                    @endif

                </div>


                {{-- اسم الجامعة --}}
                <h3>
                    {{ $uni->name }}
                </h3>


                {{-- الموقع --}}
                <span class="uni-card-loc">
                    {{ $uni->location ?? 'فلسطين' }}
                </span>


                {{-- زر عرض الجامعة --}}
                <button
                    type="button"
                    class="uni-view-btn"
                    data-id="{{ $uni->id }}"
                >
                    عرض الجامعة
                </button>

            </div>

        </div>

    @empty

        <div class="empty-state">

            <div>⌕</div>

            <h3>
                لا توجد جامعات مضافة حالياً
            </h3>

            <p>
                سيتم عرض الجامعات هنا عند إضافتها.
            </p>

        </div>

    @endforelse

</div>
                <button class="carousel-btn carousel-next" id="carouselNext"><span>→</span></button>
            </div>

            <div class="carousel-dots" id="carouselDots"></div>

            <!-- SPECIALIZATIONS -->
            <section class="specializations">
                <div class="specialization-item">
                    <div class="special-icon">✦</div>
                    <span>التصميم والفنون</span>
                </div>
                <div class="specialization-item">
                    <div class="special-icon">⌬</div>
                    <span>العلوم التطبيقية</span>
                </div>
                <div class="specialization-item">
                    <div class="special-icon">↗</div>
                    <span>إدارة الأعمال</span>
                </div>
                <div class="specialization-item">
                    <div class="special-icon">▣</div>
                    <span>العلوم الإنسانية</span>
                </div>
                <div class="specialization-item">
                    <div class="special-icon">⌁</div>
                    <span>الهندسة والتكنولوجيا</span>
                </div>
                <div class="specialization-item">
                    <div class="special-icon">♡</div>
                    <span>الطب والصحة</span>
                </div>
            </section>

            <!-- ARTICLES + FAQ -->
            <div class="bottom-content">
                
                <section class="articles-section">
                    <div class="section-small-head">
                        <div>
                            <span>محتوى يساعدك</span>
                            <h2>مقالات تهمك</h2>
                        </div>
                        <a href="#">عرض الكل ←</a>
                    </div>

                    <div class="articles-grid">
                        <article class="article-card">
                            <div class="article-icon blue">🎓</div>
                            <span>دليل الطالب</span>
                            <h3>كيف تختار الجامعة المناسبة؟</h3>
                            <p>أهم المعايير التي يجب أن تضعيها في اعتبارك قبل اختيار جامعتك.</p>
                            <a href="#">اقرئي المزيد ←</a>
                        </article>

                        <article class="article-card">
                            <div class="article-icon cyan">⚖</div>
                            <span>مقارنة</span>
                            <h3>الفرق بين الجامعات الحكومية والخاصة</h3>
                            <p>مقارنة سريعة تساعدك على فهم الفروقات بين الخيارات المتاحة.</p>
                            <a href="#">اقرأ المزيد ←</a>
                        </article>

                        <article class="article-card">
                            <div class="article-icon purple">💡</div>
                            <span>نصائح</span>
                            <h3>نصائح لأول سنة جامعية</h3>
                            <p>خطوات عملية تساعدك على بدء مشوارك الجامعي بثقة ووضوح.</p>
                            <a href="#">اقرأ المزيد ←</a>
                        </article>
                    </div>
                </section>

                <!-- FAQ -->
                <section class="faq-section">
                    <div class="section-small-head">
                        <div>
                            <span>هل لديك سؤال؟</span>
                            <h2>أسئلة شائعة</h2>
                        </div>
                        <div class="question-icon">?</div>
                    </div>

                    <div class="faq-list">
                        <div class="faq-item">
                            <button class="faq-question">
                                <span>كيف بقدر أعرف التخصصات المتوفرة بجامعة معينة؟</span>
                                <b>⌄</b>
                            </button>
                            <div class="faq-answer">
                                <p>افتح صفحة الجامعة التي تهمك واضغطي على تبويب التخصصات لتشاهد جميع التخصصات المتوفرة فيها.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">
                                <span>هل المعلومات المعروضة عن الجامعات محدثة؟</span>
                                <b>⌄</b>
                            </button>
                            <div class="faq-answer">
                                <p>نعم، نعمل على تحديث بيانات الجامعات بشكل دوري حتى تحصلين على معلومات أكثر دقة وفائدة.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question">
                                <span>كيف أقدر أشوف تفاصيل جامعة معينة؟</span>
                                <b>⌄</b>
                            </button>
                            <div class="faq-answer">
                                <p>اضغط على زر عرض الجامعة الموجود داخل بطاقة الجامعة وسيتم نقلك مباشرة إلى صفحة تفاصيلها.</p>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </section>
    </main>

    <!-- ================= QUICK VIEW MODAL ================= -->
    <div class="uni-modal-overlay" id="uniModalOverlay">
        <div class="uni-modal-box">
            <button class="uni-modal-close" id="uniModalClose" type="button" aria-label="إغلاق">&times;</button>
            
            <div class="uni-modal-cover">
                <img id="uniModalImage" src="" alt="">
                <div class="uni-modal-logo">
                    <img id="uniModalLogoImg" src="" alt="" style="display:none;">
                    <span id="uniModalLogoFallback"></span>
                </div>
            </div>

            <div class="uni-modal-body">
                <h3 id="uniModalName">—</h3>
                
                <span class="uni-modal-location">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span id="uniModalLocation">—</span>
                </span>

                <div class="uni-modal-stats">
                    <div class="uni-modal-stat">
                        <b id="uniModalStudents">—</b>
                        <span>طالب</span>
                    </div>
                    <div class="uni-modal-stat">
                        <b id="uniModalMajors">—</b>
                        <span>تخصص</span>
                    </div>
                    <div class="uni-modal-stat">
                        <b id="uniModalDeanships">—</b>
                        <span>كلية</span>
                    </div>
                </div>

                <p id="uniModalDesc" class="uni-modal-desc">—</p>
                
                <a href="#" id="uniModalMoreBtn" class="uni-modal-more-btn">
                    شاهد التفاصيل كاملة ←
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('Front_end/js/footer-index.js') }}" defer></script>
    <!-- ملف الـ JS الآن سيعمل على البطاقات التي تم إنشاؤها من قاعدة البيانات -->
    <script src="{{ asset('Front_end/js/universities.js') }}" defer></script>

</body>
</html>