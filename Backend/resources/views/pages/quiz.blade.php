@extends('layouts.app')

@section('title', 'الاستبيان الذكي — NextStep AI')

@section('css')
<link href="{{ asset('Front_end/css/quiz.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ======================= QUIZ ======================= -->
<div class="quiz-wrap">
  <div class="quiz-inner">

    <div class="quiz-head">
      <span class="quiz-eyebrow-top">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.6.5 1 1.3 1 2.1V17h6v-1.4c0-.8.4-1.6 1-2.1A6 6 0 0 0 12 3z"/></svg>
        استبيان اكتشاف الميول
      </span>
      <h1>الاستبيان الذكي</h1>
      <p>أجب عن الأسئلة التالية بصدق، وخلينا نساعدك تكتشف التخصص الأنسب لشخصيتك ومهاراتك</p>
    </div>

    <!-- Stepper -->
    <div class="quiz-stepper" id="stepper"></div>
    <div class="quiz-progress-label">السؤال <span id="progressCurrent">1</span> من <span id="progressTotal">6</span></div>

    <!-- Question card -->
    <div class="quiz-card" id="quizCard">
      <div id="questionView">
        <div class="quiz-q-eyebrow" id="qEyebrow">السؤال 1</div>
        <div class="quiz-question" id="qText"></div>
        <div class="quiz-options" id="qOptions"></div>

        <div class="quiz-nav">
          <button class="quiz-nav-btn" id="btnPrev" type="button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M11 19l-7-7 7-7"/></svg>
            السؤال السابق
          </button>
          <button class="quiz-nav-btn primary" id="btnNext" type="button">
            السؤال التالي
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
          </button>
        </div>
      </div>

      <!-- Completion state -->
      <div class="quiz-done" id="doneView" style="display:none;">
        <div class="done-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg>
        </div>
        <h2>خلصنا! 🎉</h2>
        <p>جاوبت على كل الأسئلة. راح نحلل إجاباتك ونطلعلك أنسب التخصصات المناسبة لك.</p>
        <a href="results.html" class="btn-primary" style="display:inline-flex;align-items:center;gap:8px;">
          شوف النتيجة
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>

    <!-- Finish button -->
    <div class="quiz-finish-wrap">
      <button class="quiz-finish-btn" id="btnFinish" type="button" disabled>
        إنهاء الاختبار
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg>
      </button>
    </div>

  </div>
</div>

<!-- ======================= FOOTER ======================= -->
@endsection
