@extends('layouts.app')

@section('title', 'المفضلة — NextStep AI')

@section('css')
<link href="{{ asset('Front_end/css/favorites.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ======================= SUB HEADER: breadcrumb + back + avatar ======================= -->
<div class="page-subbar">
  <div class="page-subbar-inner">
    <div class="crumb">
      <a href="../index.html">الرئيسية</a>
      <span class="sep">/</span>
      <span class="current">المفضلة</span>
    </div>
    <div class="subbar-right">
      <a href="../index.html" class="btn-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        الرجوع
      </a>
      <img src="{{ asset('Front_end/assets/5.jpg') }}" alt="صورة الطالب" class="user-avatar">
    </div>
  </div>
</div>

<!-- ======================= FAVORITES ======================= -->
<div class="fav-wrap">
  <div class="fav-inner">

    <div class="fav-head">
      <div class="fav-eyebrow">
        <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
        صفحة المفضلة
      </div>
      <h1>عناصر الطالب المفضلة</h1>
      <p>هون بتلاقي كل الجامعات والتخصصات اللي حفظتها لترجع تراجعها بأي وقت.</p>
    </div>

    <!-- Tabs -->
    <div class="fav-tabs">
      <button class="fav-tab active" data-tab="majors">
        التخصصات <span class="count" id="majorsCount">3</span>
      </button>
      <button class="fav-tab" data-tab="unis">
        الجامعات <span class="count" id="unisCount">3</span>
      </button>
    </div>

    <!-- Majors grid -->
    <div class="fav-grid" id="majorsGrid">
      <div class="fav-card major">
        <button class="fav-heart" aria-label="إزالة من المفضلة">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
        </button>
        <div class="fav-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="4" width="16" height="16" rx="2"/><path d="M8 2v4M16 2v4M8 12h8M8 16h5"/></svg>
        </div>
        <h3>هندسة الحاسوب</h3>
        <p>تخصص يجمع بين البرمجة وتصميم الأنظمة الذكية.</p>
        <div class="fav-meta"><span class="fav-match">توافق 92%</span></div>
        <button class="btn-unfav">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
          إزالة من المفضلة
        </button>
      </div>

      <div class="fav-card major">
        <button class="fav-heart" aria-label="إزالة من المفضلة">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
        </button>
        <div class="fav-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
        </div>
        <h3>هندسة معمارية</h3>
        <p>تصميم المباني والمساحات بأسلوب إبداعي ووظيفي.</p>
        <div class="fav-meta"><span class="fav-match">توافق 85%</span></div>
        <button class="btn-unfav">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
          إزالة من المفضلة
        </button>
      </div>

      <div class="fav-card major">
        <button class="fav-heart" aria-label="إزالة من المفضلة">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
        </button>
        <div class="fav-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.6.5 1 1.3 1 2.1V17h6v-1.4c0-.8.4-1.6 1-2.1A6 6 0 0 0 12 3z"/></svg>
        </div>
        <h3>ذكاء اصطناعي</h3>
        <p>تعلم الآلة وتطوير الأنظمة الذكية وتحليل البيانات.</p>
        <div class="fav-meta"><span class="fav-match">توافق 89%</span></div>
        <button class="btn-unfav">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
          إزالة من المفضلة
        </button>
      </div>
    </div>

    <!-- Universities grid -->
    <div class="fav-grid" id="unisGrid" style="display:none;">
      <div class="fav-card uni">
        <button class="fav-heart" aria-label="إزالة من المفضلة">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
        </button>
        <div class="fav-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
        </div>
        <h3>جامعة النجاح الوطنية</h3>
        <p>نابلس — من أكبر الجامعات الفلسطينية وأكثرها تنوعًا بالتخصصات.</p>
        <div class="fav-meta"><span class="fav-match">توافق 94%</span></div>
        <button class="btn-unfav">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
          إزالة من المفضلة
        </button>
      </div>

      <div class="fav-card uni">
        <button class="fav-heart" aria-label="إزالة من المفضلة">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
        </button>
        <div class="fav-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
        </div>
        <h3>جامعة بيرزيت</h3>
        <p>رام الله — سمعة أكاديمية قوية وبرامج بحثية متقدمة.</p>
        <div class="fav-meta"><span class="fav-match">توافق 88%</span></div>
        <button class="btn-unfav">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
          إزالة من المفضلة
        </button>
      </div>

      <div class="fav-card uni">
        <button class="fav-heart" aria-label="إزالة من المفضلة">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
        </button>
        <div class="fav-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
        </div>
        <h3>جامعة الخليل</h3>
        <p>الخليل — رسوم دراسية مناسبة وقرب من مناطق الجنوب.</p>
        <div class="fav-meta"><span class="fav-match">توافق 79%</span></div>
        <button class="btn-unfav">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg>
          إزالة من المفضلة
        </button>
      </div>
    </div>

    <!-- Empty states -->
    <div class="fav-empty" id="majorsEmpty">
      <div class="empty-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7.5-4.9-10-9.3C.4 8 2.1 4 6 4c2 0 3.6 1 4 2.5C10.4 5 12 4 14 4c3.9 0 5.6 4 4 7.7C19.5 16.1 12 21 12 21z"/></svg>
      </div>
      <h3>ما في تخصصات مفضلة بعد</h3>
      <p>لما تلاقي تخصص يعجبك، اضغط على أيقونة القلب لتضيفه هون.</p>
    </div>
    <div class="fav-empty" id="unisEmpty">
      <div class="empty-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
      </div>
      <h3>ما في جامعات مفضلة بعد</h3>
      <p>لما تلاقي جامعة تعجبك، اضغط على أيقونة القلب لتضيفها هون.</p>
    </div>

  </div>
</div>

<!-- ======================= FOOTER ======================= -->
@endsection
