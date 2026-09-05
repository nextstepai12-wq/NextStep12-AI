@extends('layouts.app')

@section('title', 'الرئيسية | NextStep AI')

@section('content')

  <div class="hero-media" aria-hidden="true">
    <video autoplay muted loop playsinline poster="{{ asset('assets/5.jpg') }}">
      <source src="{{ asset('assets/vedio-hero.mp4') }}" type="video/mp4">
    </video>
  </div>

<!-- ======================= HERO ======================= -->
<section class="hero">
  
  <div class="hero-overlay" aria-hidden="true"></div>

  <div class="hero-inner">
    <div class="hero-copy">
      <h1>NextStep <span>AI</span></h1>
      <h2>خطوتك الذكية نحو مستقبلك</h2>
      <p class="lead">منصة ذكية تساعدك على اكتشاف التخصص المناسب واختيار الجامعة الأفضل لك من خلال الذكاء الاصطناعي.</p>
      <div class="hero-actions">
        <a href="{{ route('pages.quiz') }}" class="btn-primary">
          ابدأ الاختبار الذكي
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
        <a href="{{ url('/universities') }}" class="btn-outline">استكشف الجامعات</a>
      </div>
      <div class="stats-container">
<div class="stats-container">
  <div class="stat-item">
    <div class="stat-number" data-target="{{ $universitiesCount }}">{{ $universitiesCount }} <span>+</span></div>
    <div class="stat-label">جامعة</div>
  </div>
  
  <div class="divider"></div>
  
  <div class="stat-item">
    <div class="stat-number" data-target="{{ $majorsCount }}">{{ $majorsCount }}<span>+</span></div>
    <div class="stat-label">تخصص</div>
  </div>
  
  <div class="divider"></div>
  
  <div class="stat-item">
    <div class="stat-number" data-target="{{ str_replace('K', '', $studentsCount) }}">{{ $studentsCount }}<span>+</span></div>
    <div class="stat-label">طالب</div>
  </div>
</div>
    </div>
  </div>
</section>

<!-- ======================= FEATURES ROW ======================= -->
<section class="features-section">
  <div class="features-row">
    <div class="feature-item">
      <div class="icon-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.6.5 1 1.3 1 2.1V17h6v-1.4c0-.8.4-1.6 1-2.1A6 6 0 0 0 12 3z"/></svg>
      </div>
      <div>
        <h3>استبيان ذكي</h3>
        <p>اكتشف مهاراتك واهتماماتك</p>
      </div>
    </div>
    <div class="feature-item">
      <div class="icon-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 3a9 9 0 0 1 9 9"/></svg>
      </div>
      <div>
        <h3>نسبة توافق دقيقة</h3>
        <p>نقارن بياناتك وبين كل جامعة وتخصص</p>
      </div>
    </div>
    <div class="feature-item">
      <div class="icon-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h6"/></svg>
      </div>
      <div>
        <h3>خطة دراسية شخصية</h3>
        <p>خطة مقترحة تناسب أهدافك</p>
      </div>
    </div>
    <div class="feature-item">
      <div class="icon-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
      </div>
      <div>
        <h3>جولات VR و 3D</h3>
        <p>استكشف الكليات والحرم الجامعي</p>
      </div>
    </div>
  </div>
</section>

<!-- ======================= STATS BAR ======================= -->
<section class="steps-section">
        <!-- شارة العنوان العلوية -->
        <div class="section-badge">
            <span class="icon">⚡</span> كيف تعمل المنصة
        </div>

        <!-- العنوان الرئيسي -->
        <h2 class="section-title">ثلاث خطوات تفصلك عن قرارك</h2>
        <p class="section-subtitle">.رحلة بسيطة وواضحة من التسجيل إلى الخطة الدراسية المخصصة</p>
        <!-- حاوية البطاقات -->
        <div class="cards-container">
            
            <!-- البطاقة الأولى (3) -->
            <div class="step-card">
                <div class="step-badge">٣</div>
                <div class="card-icon">
                    <!-- أيقونة تعبيرية أو SVG -->
<svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path fill="rgb(53, 208, 255)" d="M544 160C544 124.7 515.3 96 480 96L160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160zM352 216C352 229.3 341.3 240 328 240L216 240C202.7 240 192 229.3 192 216C192 202.7 202.7 192 216 192L328 192C341.3 192 352 202.7 352 216zM424 296C437.3 296 448 306.7 448 320C448 333.3 437.3 344 424 344L216 344C202.7 344 192 333.3 192 320C192 306.7 202.7 296 216 296L424 296zM288 424C288 437.3 277.3 448 264 448L216 448C202.7 448 192 437.3 192 424C192 410.7 202.7 400 216 400L264 400C277.3 400 288 410.7 288 424z"/></svg>

                </div>
                <h3>احصل على خطتك</h3>
                <p>استلم توصيات التخصصات والجامعات المناسبة مع خطة دراسية واضحة الخطوات.</p>
            </div>

            <!-- البطاقة الثانية (2) -->
            <div class="step-card">
                <div class="step-badge">٢</div>
                <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg"height="32" width="32" viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path fill="rgb(53, 208, 255)" d="M216 64C229.3 64 240 74.7 240 88L240 128L400 128L400 88C400 74.7 410.7 64 424 64C437.3 64 448 74.7 448 88L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 88C192 74.7 202.7 64 216 64zM216 176L160 176C151.2 176 144 183.2 144 192L144 240L496 240L496 192C496 183.2 488.8 176 480 176L216 176zM144 288L144 480C144 488.8 151.2 496 160 496L480 496C488.8 496 496 488.8 496 480L496 288L144 288z"/></svg>

                </div>
                <h3>أكمل الاختبار الذكي</h3>
                <p>أجب عن أسئلة تفاعلية تقيس ميولك وقدراتك، ويحللها الذكاء الاصطناعي فوراً.</p>
            </div>

            <!-- البطاقة الثالثة (1) -->
            <div class="step-card">
                <div class="step-badge">١</div>
                <div class="card-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" height="32" width="32" viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path fill="#35d0ff" d="M285.7 368C384.2 368 464 447.8 464 546.3C464 562.7 450.7 576 434.3 576L77.7 576C61.3 576 48 562.7 48 546.3C48 447.8 127.8 368 226.3 368L285.7 368zM528 144C541.3 144 552 154.7 552 168L552 216L600 216C613.3 216 624 226.7 624 240C624 253.3 613.3 264 600 264L552 264L552 312C552 325.3 541.3 336 528 336C514.7 336 504 325.3 504 312L504 264L456 264C442.7 264 432 253.3 432 240C432 226.7 442.7 216 456 216L504 216L504 168C504 154.7 514.7 144 528 144zM256 312C189.7 312 136 258.3 136 192C136 125.7 189.7 72 256 72C322.3 72 376 125.7 376 192C376 258.3 322.3 312 256 312z"/></svg>

                </div>
                <h3>أنشئ حسابك</h3>
                <p>سجل بياناتك واختر مسارك: طالب جديد يبحث عن تخصص، أو طالب جامعي يطور مساره.</p>
            </div>

        </div>
    </section>

<section class="cta-section">
    <div class="cta-banner">
        <h2>جاهز لاتخاذ خطوتك الذكية؟</h2>
        <p>انضم إلى آلاف الطلاب الذين اكتشفوا مسارهم الجامعي المناسب مع NextStep AI.</p>
        <div class="cta-buttons">
            <a href="{{ route('register') }}" class="btn-primary">أنشئ حسابك مجاناً ←</a>
            <a href="{{ route('login') }}" class="btn-outline">لدي حساب بالفعل</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const counters = document.querySelectorAll(".stat-number");

    counters.forEach(counter => {
      const target = +counter.getAttribute("data-target");
      const isK = counter.textContent.includes("K");
      let current = 0;
      const increment = target / 80; 

      const updateCounter = () => {
        if (current < target) {
          current += increment;
          if (current > target) current = target;

          if (isK) {
            counter.textContent = Math.ceil(current) + "K+";
          } else {
            counter.textContent = Math.ceil(current) + "+";
          }
          requestAnimationFrame(updateCounter);
        } else {
          if (isK) {
            counter.textContent = target + "K+";
          } else {
            counter.textContent = target + "+";
          }
        }
      };

      updateCounter();
    });
  });
</script>
@endsection
