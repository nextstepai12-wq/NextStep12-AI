@extends('layouts.app')

@section('title', 'نتائج الاستبيان — NextStep AI')

@section('css')
<link href="{{ asset('Front_end/css/results.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ======================= RESULTS ======================= -->
<div class="results-wrap">
  <div class="results-inner">

    <div class="results-head">
      <span class="results-eyebrow">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
        تم تحليل إجاباتك
      </span>
      <h1>هذه نتيجة الاختبار التي تناسبك</h1>
      <p>بناءً على إجاباتك على الاستبيان الذكي، حللنا ميولك ومهاراتك ولقينالك أقرب التخصصات والجامعات المناسبة لك</p>
    </div>

    <!-- Top match: main recommended major -->
    <div class="top-match">
      <div class="top-match-info">
        <span class="top-match-tag">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 2l9 4.5-9 4.5-9-4.5 9-4.5z"/><path d="M3 6.5v6c0 2.5 4 4.5 9 4.5s9-2 9-4.5v-6"/></svg>
          التخصص الأول المقترح
        </span>
        <div class="top-match-name">علوم الحاسوب</div>
        <p class="top-match-desc">تخصص يناسب تفكيرك المنطقي وشغفك بحل المشاكل باستخدام التكنولوجيا، وفيه فرص عمل واسعة ومتنوعة.</p>
      </div>
      <div class="match-circle">
        <div class="pct">94<span>%</span></div>
        <div class="pct-label">نسبة التوافق</div>
      </div>
    </div>

    <!-- University compatibility -->
    <div class="section-title"><span class="dot"></span>نسبة التوافق مع الجامعة</div>
    <div class="uni-grid">

      <div class="uni-card">
        <div class="uni-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
        </div>
        <div class="uni-pct">92<span>%</span></div>
        <div class="uni-bar"><div class="uni-bar-fill" style="width:92%;"></div></div>
        <div class="uni-name">جامعة النجاح الوطنية</div>
      </div>

      <div class="uni-card">
        <div class="uni-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
        </div>
        <div class="uni-pct">87<span>%</span></div>
        <div class="uni-bar"><div class="uni-bar-fill" style="width:87%;"></div></div>
        <div class="uni-name">الجامعة الإسلامية</div>
      </div>

      <div class="uni-card">
        <div class="uni-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
        </div>
        <div class="uni-pct">81<span>%</span></div>
        <div class="uni-bar"><div class="uni-bar-fill" style="width:81%;"></div></div>
        <div class="uni-name">جامعة الأزهر</div>
      </div>

    </div>

    <!-- Other suggested majors -->
    <div class="section-title"><span class="dot"></span>تخصصات أخرى تناسبك</div>
    <div class="majors-card">
      <div class="majors-list">
        <span class="major-chip">
          <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg></span>
          الذكاء الاصطناعي
        </span>
        <span class="major-chip">
          <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg></span>
          الأمن السيبراني
        </span>
        <span class="major-chip">
          <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg></span>
          هندسة الحاسوب
        </span>
        <span class="major-chip">
          <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg></span>
          علم البيانات
        </span>
        <span class="major-chip">
          <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg></span>
          نظم المعلومات
        </span>
      </div>
    </div>

    <!-- Actions -->
    <div class="results-actions">
      <a href="quiz.html" class="btn-retake">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        إعادة الاختبار
      </a>
      <a href="student-signup.html" class="btn-continue">
        تابع وأنشئ حسابك
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </a>
    </div>

  </div>
</div>

<!-- ======================= FOOTER ======================= -->
@endsection
