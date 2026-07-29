@extends('layouts.app')

@section('title', 'الرئيسية — NextStep AI')

@section('css')
<link href="{{ asset('NextStepAi-front/css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ======================= HERO ======================= -->
<section class="hero">
  <div class="hero-bg">
  <img src="{{ asset('NextStepAi-front/assets/hero-bg-1400x700.jpg') }}" alt="" style="width:100%;height:100%;object-fit:cover;">
      <defs>
        <linearGradient id="sky" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stop-color="#2F6BFF"/>
          <stop offset="100%" stop-color="#173B73"/>
        </linearGradient>
      </defs>
      <rect width="1400" height="700" fill="url(#sky)"/>
      <rect x="60" y="320" width="140" height="270" fill="#1F2937" opacity="0.5"/>
      <rect x="220" y="260" width="110" height="330" fill="#1F2937" opacity="0.4"/>
      <rect x="980" y="290" width="150" height="300" fill="#1F2937" opacity="0.45"/>
      <rect x="1150" y="340" width="90" height="250" fill="#1F2937" opacity="0.35"/>
      <rect x="1260" y="300" width="110" height="290" fill="#1F2937" opacity="0.4"/>
      <g fill="#48E6B0" opacity="0.3">
        <rect x="80" y="345" width="14" height="16"/><rect x="105" y="345" width="14" height="16"/><rect x="130" y="345" width="14" height="16"/>
        <rect x="80" y="385" width="14" height="16"/><rect x="105" y="385" width="14" height="16"/><rect x="130" y="385" width="14" height="16"/>
        <rect x="1010" y="320" width="14" height="16"/><rect x="1035" y="320" width="14" height="16"/><rect x="1060" y="320" width="14" height="16"/>
        <rect x="1010" y="360" width="14" height="16"/><rect x="1035" y="360" width="14" height="16"/><rect x="1060" y="360" width="14" height="16"/>
      </g>
      <rect x="0" y="590" width="1400" height="110" fill="#0F2547"/>
      <path d="M0 590 L1400 590 L1400 615 Q700 645 0 615 Z" fill="#122E5D"/>
      <path d="M560 700 L640 590 L760 590 L840 700 Z" fill="#173B73" opacity="0.55"/>
      <g transform="translate(980,400)">
        <ellipse cx="30" cy="18" rx="19" ry="21" fill="#0B1B2C"/>
        <path d="M6 44 Q4 32 30 32 Q56 32 54 44 L61 145 Q61 162 50 165 L11 165 Q0 162 0 145 Z" fill="#16324F"/>
        <rect x="15" y="62" width="30" height="50" rx="9" fill="#0B1B2C"/>
        <path d="M0 145 Q-2 168 9 184 L18 165 Z" fill="#0B1B2C"/>
        <path d="M61 145 Q63 168 52 184 L43 165 Z" fill="#0B1B2C"/>
        <rect x="19" y="168" width="13" height="68" fill="#16324F"/>
        <rect x="36" y="168" width="13" height="68" fill="#122A45"/>
      </g>
      <circle cx="1250" cy="150" r="130" fill="#48E6B0" opacity="0.08"/>
    </svg>
  </div>

  <div class="hero-inner">
    <div class="hero-copy">
      <h1>NextStep <span>AI</span></h1>
      <h2>خطوتك الذكية نحو مستقبلك</h2>
      <p class="lead">منصة ذكية تساعدك على اكتشاف التخصص المناسب واختيار الجامعة الأفضل لك من خلال الذكاء الاصطناعي.</p>
      <div class="hero-actions">
        <a href="{{ route('register') }}" class="btn-primary">
          ابدأ الاختبار الذكي
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
        <a href="#" class="btn-outline">استكشف الجامعات</a>
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
<div class="stats-bar">
  <div class="stats-inner">
    <div class="stat">
      <div class="num">+<span>{{ $universitiesCount ?? 50 }}</span></div>
      <div class="lbl">جامعة</div>
    </div>
    <div class="stat">
      <div class="num">+<span>{{ $majorsCount ?? 2000 }}</span></div>
      <div class="lbl">تخصص</div>
    </div>
    <div class="stat">
      <div class="num">+<span>{{ $studentsCount ?? '100K' }}</span></div>
      <div class="lbl">طالب</div>
    </div>
    <div class="stat tagline">كل ما تحتاجه في مكان واحد</div>
  </div>
</div>
@endsection
