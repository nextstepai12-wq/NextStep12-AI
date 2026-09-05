@extends('layouts.app')

@section('title', $university->name . ' — NextStep AI')

@section('css')
<link href="{{ asset('css/university-details.css') }}" rel="stylesheet">

<style>
/* =========================================================
   نافذة "نسبة توافقك مع الجامعة"
   ========================================================= */

.match-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(15, 23, 42, .55);
    backdrop-filter: blur(4px);
    opacity: 0;
    visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}

.match-modal-overlay.open {
    opacity: 1;
    visibility: visible;
}

.match-modal-box {
    position: relative;
    width: min(420px, 100%);
    max-height: 88vh;
    overflow-y: auto;
    padding: 34px 26px 28px;
    border-radius: 22px;
    background: #ffffff;
    box-shadow: 0 25px 60px rgba(15, 23, 42, .25);
    text-align: center;
    transform: translateY(18px) scale(.97);
    transition: transform .3s ease;
}

.match-modal-overlay.open .match-modal-box {
    transform: translateY(0) scale(1);
}

.match-modal-close {
    position: absolute;
    top: 14px;
    left: 14px;
    width: 32px;
    height: 32px;
    display: grid;
    place-items: center;
    border: 0;
    border-radius: 50%;
    background: #f1f5f9;
    color: #334155;
    font-size: 18px;
    line-height: 1;
    cursor: pointer;
    transition: .2s ease;
}

.match-modal-close:hover {
    background: var(--blue, #2f6bff);
    color: #ffffff;
}

.match-modal-circle {
    width: 110px;
    height: 110px;
    margin: 0 auto 12px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(47, 107, 255, .08), transparent 70%);
    border: 6px solid rgba(47, 107, 255, .12);
}

.match-modal-pct {
    font-family: "Poppins", sans-serif;
    font-size: 30px;
    font-weight: 800;
    color: var(--blue, #2f6bff);
}

.match-modal-pct span {
    font-size: 16px;
}

.match-modal-tier {
    display: inline-block;
    margin-bottom: 10px;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
}

.match-modal-tier.tier-high {
    color: var(--mint, #22c55e);
    background: rgba(72, 230, 176, .14);
}

.match-modal-tier.tier-good {
    color: var(--blue, #2f6bff);
    background: rgba(47, 107, 255, .1);
}

.match-modal-tier.tier-medium {
    color: var(--orange, #f5a623);
    background: rgba(245, 166, 35, .12);
}

.match-modal-box h3 {
    margin: 0 0 8px;
    color: #0f172a;
    font-size: 17px;
    font-weight: 800;
}

.match-modal-box p {
    margin: 0 0 20px;
    color: #64748b;
    font-size: 13px;
    line-height: 1.9;
}

.match-modal-note {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    padding: 10px 14px;
    border-radius: 12px;
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    text-align: right;
}

.match-modal-note svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    stroke: var(--blue, #2f6bff);
}

.match-modal-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 14px;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: rgba(47, 107, 255, .1);
    color: var(--blue, #2f6bff);
}

.match-modal-icon svg {
    width: 26px;
    height: 26px;
}

.match-modal-retake {
    display: block;
    width: 100%;
    height: 46px;
    line-height: 46px;
    border-radius: 12px;
    background: linear-gradient(135deg, #173873, var(--blue, #2f6bff));
    color: #ffffff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 800;
    transition: transform .25s ease, box-shadow .25s ease;
}

.match-modal-retake:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(47, 107, 255, .25);
}
</style>
@endsection

@section('content')

<!-- ======================= HERO / COVER & HERO CARD ======================= -->
<div class="uni-hero-wrapper">

  <!-- BACK LINK BUTTON (Top Left Overlay) -->
  <div class="back-link-overlay">
    <a href="{{ route('universities.index') }}" class="back-link-btn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
      الرجوع لكل الجامعات
    </a>
  </div>

  <!-- COVER IMAGE -->
  <div class="uni-cover">
    <div class="cover-img">
      @if($university->cover_image)
        <img src="{{ $university->cover_image }}" alt="غلاف {{ $university->name }}" class="cover-img-real"
             onerror="this.style.display='none';">
      @else
        <img src="{{ asset('assets/universities/' . $university->id . '/cover.jpg') }}"
             alt="غلاف {{ $university->name }}" class="cover-img-real"
             onerror="this.style.display='none';">
      @endif
    </div>
  </div>

  <!-- HERO INFO CARD (LOGO + TITLE + STATS) -->
  <div class="hero-card-container">
    <div class="hero-card">

      <!-- LOGO -->
      <div class="uni-logo-box">
        @if($university->logo)
          <img src="{{ $university->logo }}" alt="شعار {{ $university->name }}" class="uni-logo-img"
               onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
          <svg style="display:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
        @else
          <img src="{{ asset('assets/universities/' . $university->id . '/logo.png') }}"
               alt="شعار {{ $university->name }}" class="uni-logo-img"
               onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
          <svg style="display:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
        @endif
      </div>

      <!-- TEXT / META -->
      <div class="hero-card-text">
        <h1>{{ $university->name }}</h1>
        <div class="uni-meta">
          <span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span>{{ $university->location ?? 'غير محدد' }}</span>
          </span>
          @if($university->website_url)
          <span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"/></svg>
            <a href="{{ $university->website_url }}" target="_blank" rel="noopener">{{ str_replace(['https://', 'http://'], '', $university->website_url) }}</a>
          </span>
          @endif
        </div>
      </div>

      <!-- STATS BOXES INSIDE HERO CARD -->
      <div class="hero-stats-group">
        <div class="stat-item">
          <div class="stat-icon-bg purple-bg">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0v-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v5m-4 0h4"/></svg>
          </div>
          <b>{{ $deanshipsCount }}</b>
          <span>كلية</span>
        </div>
        <div class="stat-item">
          <div class="stat-icon-bg blue-bg">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
          </div>
          <b>{{ $majorsCount }}</b>
          <span>تخصص</span>
        </div>
        <div class="stat-item">
          <div class="stat-icon-bg green-bg">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <b>—</b>
          <span>طالب</span>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ======================= TABS BAR ======================= -->
<div class="tabs-container" id="tabsContainer">
  <div class="uni-tabs" role="tablist">
    <button class="uni-tab active" data-tab="about" type="button">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        الجامعة
    </button>
    <button class="uni-tab" data-tab="deanships" type="button">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16"/></svg>
      العمادات
    </button>
    <button class="uni-tab" data-tab="majors" type="button">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/></svg>
      التخصصات
    </button>
    <button class="uni-tab" data-tab="news" type="button">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/></svg>
      الأخبار
    </button>
    <button class="uni-tab" data-tab="contact" type="button">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
      التواصل
    </button>
  </div>
</div>

<!-- ======================= CONTENT PANELS ======================= -->
<div class="uni-content" id="uniContent">

  <!-- ---- نبذة عن الجامعة ---- -->
  <div class="uni-panel" data-panel="about">
    <div class="about-layout">

      <!-- العمود الأيمن (الرئيسي) -->
      <div class="about-main-card">
        <h3 class="section-title">نبذة عن الجامعة</h3>
        <p class="about-desc-text">{{ $university->description ?? 'ما في وصف متوفر حالياً.' }}</p>

        <!-- الرؤية والرسالة -->
        @if($university->vision_mission)
        <div class="vision-card-styled">
          <div class="vision-header">
            <span class="vision-title">الرؤية والرسالة</span>
            <div class="vision-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.6.5 1 1.3 1 2.1V17h6v-1.4c0-.8.4-1.6 1-2.1A6 6 0 0 0 12 3z"/></svg>
            </div>
          </div>
          <p class="vision-text">{{ $university->vision_mission }}</p>
        </div>
        @endif

        <!-- CTA Buttons -->
        <div class="uni-cta-row">
          <button class="uni-tab-jump btn-outline-contact" data-jump="contact" type="button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.62 2.6a2 2 0 0 1-.45 2.11L8.09 9.62a16 16 0 0 0 6 6l1.19-1.19a2 2 0 0 1 2.11-.45c.83.29 1.7.5 2.6.62A2 2 0 0 1 22 16.92z"/></svg>
            تواصل معنا
          </button>
          <button type="button" class="btn-primary-match" id="matchTriggerBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
            اعرف نسبة توافقك مع الجامعة
          </button>
        </div>
      </div>

      <!-- العمود الأيسر (معلومات سريعة) -->
      <div class="quick-facts-card">
        <h3>معلومات سريعة</h3>
        <div class="fact-list">
          <div class="fact-item">
            <div class="fact-label-group">
              <span class="fact-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 8l6 6M4 14l6-6 2 2M2 5h12M7 2v3M22 22l-5-10-5 10M14 18h6"/></svg></span>
              <span>لغة الدراسة</span>
            </div>
            <span class="fact-value">عربي / إنجليزي</span>
          </div>

          <div class="fact-item">
            <div class="fact-label-group">
              <span class="fact-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16"/></svg></span>
              <span>نوع القطاع</span>
            </div>
            <span class="fact-value">غير محدد</span>
          </div>

          <div class="fact-item">
            <div class="fact-label-group">
              <span class="fact-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg></span>
              <span>عدد الكليات</span>
            </div>
            <span class="fact-value">{{ $deanshipsCount }}</span>
          </div>

          <div class="fact-item">
            <div class="fact-label-group">
              <span class="fact-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
              <span>الموقع</span>
            </div>
            <span class="fact-value">{{ $university->location ?? 'غير محدد' }}</span>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- ---- العمادات والكليات ---- -->
  <div class="uni-panel" data-panel="deanships" style="display:none;">
    <div class="deanships-grid" id="deanshipsGrid">
      @forelse($university->deanshipsFaculties as $deanship)
        <div class="deanship-card" data-deanship-id="{{ $deanship->id }}">
          <div class="deanship-cover">
            @if($deanship->cover_image)
              <img src="{{ $deanship->cover_image }}" alt="{{ $deanship->name }}" onerror="this.style.display='none';">
            @endif
          </div>
          <div class="deanship-body">
            <span class="deanship-type-badge">{{ $deanship->type === 'faculty' ? 'كلية' : 'عمادة' }}</span>
            <h4>{{ $deanship->name }}</h4>
            <p class="deanship-desc">{{ $deanship->description ?? 'ما في وصف متوفر.' }}</p>
            <div class="deanship-meta">
              <span>{{ $deanship->dean_name ?? '—' }}</span>
              <span>{{ $deanship->email ?? '—' }}</span>
            </div>
            <button class="btn-view-majors" type="button">عرض التخصصات التابعة</button>
          </div>
        </div>
      @empty
        <div class="no-results">ما في كليات مضافة حالياً.</div>
      @endforelse
    </div>
  </div>

  <!-- ---- التخصصات ---- -->
  <div class="uni-panel" data-panel="majors" style="display:none;">
    <div class="majors-toolbar">
      <input type="text" id="majorSearch" placeholder="ابحثي عن تخصص...">
      <span class="majors-count" id="majorsCount">{{ $majorsCount }} تخصصات</span>
    </div>
    <div class="majors-grid" id="majorsGrid">
      @php
        $hasMajors = false;
      @endphp
      @foreach($university->deanshipsFaculties as $deanship)
        @foreach($deanship->majors as $major)
          @php $hasMajors = true; @endphp
          <div class="major-card" data-name="{{ $major->title }}">
            <h4>{{ $major->title }}</h4>
            <div class="major-college">{{ $deanship->name }}</div>
          </div>
        @endforeach
      @endforeach
      @if(!$hasMajors)
        <div class="no-results">ما في تخصصات مضافة حالياً.</div>
      @endif
    </div>
  </div>

  <!-- ---- الأخبار ---- -->
  <div class="uni-panel" data-panel="news" style="display:none;">
    <div class="news-grid">
      {{-- لا يوجد News Model في المشروع حالياً — يتم عرض رسالة بديلة --}}
      <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 40px 20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:48px; height:48px; margin:0 auto 16px; display:block; color:#94a3b8;">
          <path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"/>
        </svg>
        <h4 style="margin:0 0 8px; color:#334155; font-size:16px; font-weight:700;">لا توجد أخبار حالياً</h4>
        <p style="margin:0; color:#64748b; font-size:13px;">سيتم عرض أخبار الجامعة هنا عند إضافتها.</p>
      </div>
    </div>
  </div>

  <!-- ---- التواصل ---- -->
  <div class="uni-panel" data-panel="contact" style="display:none;">
    <div class="contact-grid">
      <div class="contact-box">
        <div class="c-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 6l-10 7L2 6"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg></div>
        <div>
          <div class="c-label">الموقع الإلكتروني</div>
          <div class="c-value">
            @if($university->website_url)
              <a href="{{ $university->website_url }}" target="_blank" rel="noopener">{{ $university->website_url }}</a>
            @else
              غير متوفر
            @endif
          </div>
        </div>
      </div>
      <div class="contact-box">
        <div class="c-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div>
          <div class="c-label">العنوان</div>
          <div class="c-value">{{ $university->location ?? '—' }}</div>
        </div>
      </div>
      @if($university->contact_info)
      <div class="contact-box">
        <div class="c-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.62 2.6a2 2 0 0 1-.45 2.11L8.09 9.62a16 16 0 0 0 6 6l1.19-1.19a2 2 0 0 1 2.11-.45c.83.29 1.7.5 2.6.62A2 2 0 0 1 22 16.92z"/></svg></div>
        <div>
          <div class="c-label">معلومات التواصل</div>
          <div class="c-value">{{ $university->contact_info }}</div>
        </div>
      </div>
      @endif
    </div>
  </div>

</div>

<!-- ======================= NAFETHA MONBATHEQA (Generic Modal) للعمادات والتخصصات ======================= -->
<div class="modal-overlay" id="genericModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3 id="modalTitle">العنوان</h3>
      <button class="modal-close" id="modalCloseBtn" type="button" aria-label="إغلاق">&times;</button>
    </div>
    <div class="modal-body">
      <div class="modal-grid" id="modalGrid"></div>
    </div>
  </div>
</div>

<!-- ======================= MATCH PERCENTAGE MODAL (نسبة التوافق مع الجامعة) ======================= -->
<div class="match-modal-overlay" id="matchModalOverlay">
  <div class="match-modal-box">

    <button class="match-modal-close" id="matchModalClose" type="button" aria-label="إغلاق">&times;</button>

    <!-- الحالة 1: عندنا نسبة توافق فعلية محسوبة مع هاي الجامعة بالذات -->
    <div class="match-modal-state" id="matchStateFound" style="display:none;">

      <div class="match-modal-circle">
        <div class="match-modal-pct" id="matchPct">—<span>%</span></div>
      </div>

      <span class="match-modal-tier" id="matchTierLabel">—</span>

      <h3 id="matchMajorName">—</h3>
      <p id="matchMajorDesc">—</p>

      <div class="match-modal-note">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 16v-4M12 8h.01"/><circle cx="12" cy="12" r="10"/></svg>
        <span>هاي النسبة محسوبة بناءً على نتيجة آخر استبيان ذكي أخذتيه</span>
      </div>

      <a href="{{ route('pages.results') }}" class="match-modal-retake">شاهدي التفاصيل الكاملة ←</a>

    </div>

    <!-- الحالة 2: أخدت الاستبيان، بس هاي الجامعة مش من ضمن أفضل توافقاتك -->
    <div class="match-modal-state" id="matchStateGeneric" style="display:none;">

      <div class="match-modal-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
      </div>

      <h3>ما في نسبة توافق محسوبة مع هاي الجامعة تحديداً</h3>
      <p>
        بس حسب نتيجة استبيانك، أقرب تخصص إلك هو
        <b id="matchGenericMajor">—</b>
        بنسبة توافق
        <b id="matchGenericPercent">—%</b>.
        أعيدي الاختبار عشان نقدر نحسبلك نسبة توافق دقيقة مع هاي الجامعة بالذات.
      </p>

      <a href="{{ route('pages.results') }}" class="match-modal-retake">شاهدي نتيجتك الكاملة ←</a>

    </div>

    <!-- الحالة 3: ما أخدت الاستبيان أصلاً -->
    <div class="match-modal-state" id="matchStateEmpty" style="display:none;">

      <div class="match-modal-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.6.5 1 1.3 1 2.1V17h6v-1.4c0-.8.4-1.6 1-2.1A6 6 0 0 0 12 3z"/></svg>
      </div>

      <h3>لسا ما أخدتي الاستبيان الذكي</h3>
      <p>خذي الاستبيان الذكي حتى نقدر نحسبلك نسبة توافقك مع هاي الجامعة والتخصص المناسب إلك.</p>

      <a href="{{ route('pages.quiz') }}" class="match-modal-retake">ابدئي الاستبيان الآن</a>

    </div>

  </div>
</div>

@endsection

@section('scripts')
<script>
// ======================= University ID للـ JS =======================
const UNIVERSITY_ID = {{ $university->id }};

// ======================= منطق التبويبات =======================
const tabs = document.querySelectorAll('.uni-tab');
const panels = document.querySelectorAll('.uni-panel');

function activateTab(target){
  tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === target));
  panels.forEach(p => { p.style.display = (p.dataset.panel === target) ? 'block' : 'none'; });

  const tabsContainer = document.getElementById('tabsContainer');
  if (tabsContainer) {
    const offset = 20;
    const bodyRect = document.body.getBoundingClientRect().top;
    const elementRect = tabsContainer.getBoundingClientRect().top;
    const elementPosition = elementRect - bodyRect;
    const offsetPosition = elementPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    });
  }
}

tabs.forEach(tab => tab.addEventListener('click', () => activateTab(tab.dataset.tab)));
document.querySelectorAll('.uni-tab-jump').forEach(btn => {
  btn.addEventListener('click', () => activateTab(btn.dataset.jump));
});

// ======================= البحث في التخصصات =======================
const majorSearchInput = document.getElementById('majorSearch');
const majorsGrid = document.getElementById('majorsGrid');
const majorsCountEl = document.getElementById('majorsCount');

if (majorSearchInput && majorsGrid) {
  majorSearchInput.addEventListener('input', function() {
    const query = this.value.trim().toLowerCase();
    const cards = majorsGrid.querySelectorAll('.major-card');
    let visibleCount = 0;

    cards.forEach(card => {
      const name = (card.dataset.name || '').toLowerCase();
      const college = card.querySelector('.major-college');
      const collegeName = college ? college.textContent.toLowerCase() : '';
      const match = !query || name.includes(query) || collegeName.includes(query);
      card.style.display = match ? '' : 'none';
      if (match) visibleCount++;
    });

    if (majorsCountEl) {
      majorsCountEl.textContent = visibleCount + ' تخصصات';
    }
  });
}

// ======================= منطق النافذة المنبثقة (Modal) =======================
const genericModal = document.getElementById('genericModal');
const modalTitleEl = document.getElementById('modalTitle');
const modalGridEl = document.getElementById('modalGrid');
const modalCloseBtn = document.getElementById('modalCloseBtn');

function openModal(title, itemsHTML) {
  modalTitleEl.textContent = title;
  modalGridEl.innerHTML = itemsHTML;
  genericModal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  genericModal.classList.remove('open');
  document.body.style.overflow = '';
}

if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
if (genericModal) genericModal.addEventListener('click', (e) => {
  if (e.target === genericModal) closeModal();
});
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') { closeModal(); closeMatchModal(); }
});

// ======================= ربط زر "عرض التخصصات التابعة" =======================
const deanshipsGrid = document.getElementById('deanshipsGrid');
if (deanshipsGrid) {
  deanshipsGrid.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-view-majors');
    if (!btn) return;

    const card = btn.closest('.deanship-card');
    if (!card) return;

    const collegeName = card.querySelector('h4').textContent.trim();

    const allMajors = Array.from(document.querySelectorAll('#majorsGrid .major-card'));
    const matched = allMajors.filter(m => {
      const collegeEl = m.querySelector('.major-college');
      return collegeEl && collegeEl.textContent.trim() === collegeName;
    });

    const wrapper = document.createElement('div');
    if (matched.length) {
      matched.forEach(m => wrapper.appendChild(m.cloneNode(true)));
    } else {
      wrapper.innerHTML = '<div class="no-results">ما في تخصصات مضافة لهاي الكلية حالياً.</div>';
    }

    openModal(`تخصصات ${collegeName}`, wrapper.innerHTML);
  });
}

// ======================= "شاهد المزيد" =======================
function setupShowMore(containerId, itemSelector, limit, modalTitle) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const oldBtn = container.querySelector('.show-more-btn');
  if (oldBtn) oldBtn.remove();

  const items = Array.from(container.querySelectorAll(itemSelector));
  if (!items.length) return;

  items.forEach((item, idx) => {
    item.style.display = idx < limit ? '' : 'none';
  });

  if (items.length > limit) {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'show-more-btn';
    btn.textContent = `شاهد المزيد (${items.length - limit}+)`;
    btn.addEventListener('click', () => {
      const wrapper = document.createElement('div');
      items.forEach(item => wrapper.appendChild(item.cloneNode(true)));
      openModal(modalTitle, wrapper.innerHTML);
    });
    container.appendChild(btn);
  }
}

// تفعيل "شاهد المزيد" على العمادات والتخصصات
setupShowMore('deanshipsGrid', '.deanship-card', 2, 'كل العمادات والكليات');
setupShowMore('majorsGrid', '.major-card', 4, 'كل التخصصات');

// ======================= منطق نافذة "نسبة توافقك مع الجامعة" =======================
const MATCH_STORAGE_KEY = 'nextstep_quiz_result';

const matchModalOverlay = document.getElementById('matchModalOverlay');
const matchModalClose = document.getElementById('matchModalClose');
const matchTriggerBtn = document.getElementById('matchTriggerBtn');

const matchStateFound = document.getElementById('matchStateFound');
const matchStateGeneric = document.getElementById('matchStateGeneric');
const matchStateEmpty = document.getElementById('matchStateEmpty');

const tierLabels = { high: 'توافق عالي', good: 'توافق جيد', medium: 'توافق متوسط' };

function openMatchModal() {
  matchModalOverlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeMatchModal() {
  if (matchModalOverlay) {
    matchModalOverlay.classList.remove('open');
    document.body.style.overflow = '';
  }
}

if (matchModalClose) matchModalClose.addEventListener('click', closeMatchModal);
if (matchModalOverlay) matchModalOverlay.addEventListener('click', (e) => {
  if (e.target === matchModalOverlay) closeMatchModal();
});

function getStoredQuizResult() {
  try {
    const raw = localStorage.getItem(MATCH_STORAGE_KEY);
    return raw ? JSON.parse(raw) : null;
  } catch (err) {
    return null;
  }
}

function prepareMatchModal() {
  [matchStateFound, matchStateGeneric, matchStateEmpty]
    .forEach(el => { if (el) el.style.display = 'none'; });

  const result = getStoredQuizResult();
  const currentId = UNIVERSITY_ID;

  // الحالة 3: ما أخدت الاستبيان أصلاً
  if (!result) {
    if (matchStateEmpty) matchStateEmpty.style.display = 'block';
    return;
  }

  const matchedUni =
    (result.universities || []).find(u => u.id === currentId);

  // الحالة 1: عندنا نسبة توافق محسوبة مع هاي الجامعة بالذات
  if (matchedUni && matchedUni.percent !== null && matchedUni.percent !== undefined) {
    document.getElementById('matchPct').innerHTML =
      `${matchedUni.percent}<span>%</span>`;

    const tierLabelEl = document.getElementById('matchTierLabel');
    tierLabelEl.textContent =
      matchedUni.tierLabel || tierLabels[matchedUni.tier] || '';
    tierLabelEl.className = `match-modal-tier tier-${matchedUni.tier}`;

    document.getElementById('matchMajorName').textContent =
      (result.topMajor && result.topMajor.name) || '—';

    document.getElementById('matchMajorDesc').textContent =
      (result.topMajor && result.topMajor.description) || '';

    matchStateFound.style.display = 'block';
    return;
  }

  // الحالة 2: أخدت الاستبيان بس هاي الجامعة مش ضمن نتائجها
  document.getElementById('matchGenericMajor').textContent =
    (result.topMajor && result.topMajor.name) || '—';

  document.getElementById('matchGenericPercent').textContent =
    `${(result.topMajor && result.topMajor.percent) ?? '—'}%`;

  if (matchStateGeneric) matchStateGeneric.style.display = 'block';
}

if (matchTriggerBtn) {
  matchTriggerBtn.addEventListener('click', () => {
    prepareMatchModal();
    openMatchModal();
  });
}
</script>
@endsection
