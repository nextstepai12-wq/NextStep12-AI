@extends('layouts.app')

@section('title', 'الاستبيان الذكي — NextStep AI')

@section('css')
<link href="{{ asset('css/quiz.css') }}" rel="stylesheet">
<style>
/* Toast تنبيه عند تجاوز الحد الأقصى للاختيارات */
.quiz-toast {
  position: fixed;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%) translateY(100px);
  background: var(--navy, #173b73);
  color: #fff;
  padding: 12px 24px;
  border-radius: 999px;
  font-size: 13.5px;
  font-weight: 700;
  box-shadow: 0 10px 25px rgba(23, 59, 115, 0.25);
  opacity: 0;
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  z-index: 9999;
  pointer-events: none;
}
.quiz-toast.show {
  transform: translateX(-50%) translateY(0);
  opacity: 1;
}
</style>
@endsection

@section('content')
<!-- ======================= QUIZ ======================= -->
<div class="quiz-wrap">
  <div class="ring-wrap" id="ringWrap">
    <div class="quiz-card" id="quizCard">

      <!-- Loading View -->
      <div class="quiz-loading" id="quizLoading">
        <div class="quiz-spinner"></div>
        <span>جاري تحميل أسئلة الاستبيان...</span>
      </div>

      <!-- Question View -->
      <div id="questionView" style="display:none;">
        <div class="card-top">
          <div class="mini-path" id="miniPath"></div>
          <div class="q-counter"><b id="qNum">1</b>/<span id="qTotal">...</span></div>
        </div>

        <div class="quiz-question" id="qText"></div>
        <div style="font-size: 12.5px; color: var(--blue, #2f6bff); font-weight: 700; margin-top: -16px; margin-bottom: 18px;">
          💡 يمكنك اختيار إجابة واحدة أو إجابتين كحد أقصى
        </div>
        <div class="quiz-options" id="qOptions"></div>

        <div class="quiz-nav">
          <button class="quiz-nav-btn" id="btnPrev" type="button" disabled>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M11 19l-7-7 7-7"/></svg>
            السابق
          </button>
          <button class="quiz-finish-btn" id="btnFinish" type="button" disabled>
            إنهاء الاختبار
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg>
          </button>
          <button class="quiz-nav-btn primary" id="btnNext" type="button">
            التالي
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
        <p>جاوبت على كل الأسئلة. حللنا إجاباتك وطلعنالك أنسب التخصصات المناسبة لميولك ومهاراتك.</p>
        <a href="{{ route('pages.results') }}" class="quiz-nav-btn primary" style="display:inline-flex;align-items:center;gap:8px;text-decoration:none;">
          شوف النتيجة
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
      </div>

    </div>
  </div>
</div>

<!-- Toast Container -->
<div class="quiz-toast" id="quizToast">يمكنك اختيار إجابتين كحد أقصى لهذا السؤال</div>
@endsection

@section('scripts')
<script>
/* ألوان الهوية المستخدمة بالـ burst والـ confetti */
const brandColors = ['#2f6bff', '#48e6b0', '#173b73'];

/* ======================= STATE ======================= */
let questions = [];
let current = 0;
let answers = []; // Array of objects: [{ question_id, selected_option_ids: [] }]
let currentInterestId = null;
let attemptToken = null;
let totalQuestions = 0;

/* ======================= DOM ======================= */
const ringWrap = document.getElementById('ringWrap');
const quizCard = document.getElementById('quizCard');
const quizLoading = document.getElementById('quizLoading');
const questionView = document.getElementById('questionView');
const doneView = document.getElementById('doneView');

const miniPath = document.getElementById('miniPath');
const qNum = document.getElementById('qNum');
const qTotal = document.getElementById('qTotal');
const qText = document.getElementById('qText');
const qOptions = document.getElementById('qOptions');

const btnPrev = document.getElementById('btnPrev');
const btnNext = document.getElementById('btnNext');
const btnFinish = document.getElementById('btnFinish');
const quizToast = document.getElementById('quizToast');

let toastTimeout = null;
function showLimitToast(msg) {
  if (msg) quizToast.textContent = msg;
  quizToast.classList.add('show');
  clearTimeout(toastTimeout);
  toastTimeout = setTimeout(() => {
    quizToast.classList.remove('show');
  }, 2400);
}

/* ======================= API FETCH ======================= */
async function loadQuestions() {
  const urlParams = new URLSearchParams(window.location.search);
  const interestParam = urlParams.get('interest_id');
  const apiUrl = '/quiz/questions' + (interestParam ? `?interest_id=${interestParam}` : '');

  try {
    quizLoading.style.display = 'flex';
    questionView.style.display = 'none';

    const response = await fetch(apiUrl, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    const data = await response.json();

    if (!response.ok || data.status !== 'success') {
      quizLoading.innerHTML = `
        <div class="quiz-empty-state">
          <p>${data.message || 'حدث خطأ أثناء تحميل الأسئلة.'}</p>
          <a href="/" class="quiz-nav-btn primary" style="margin-top:10px;text-decoration:none;">العودة للرئيسية</a>
        </div>
      `;
      return;
    }

    questions = data.questions || [];
    currentInterestId = data.interest_id;
    attemptToken = data.attempt_token;
    totalQuestions = Number(data.total) || questions.length;

    if (questions.length === 0) {
      quizLoading.innerHTML = `
        <div class="quiz-empty-state">
          <p>لا توجد أسئلة متوفرة لهذا المجال حالياً.</p>
        </div>
      `;
      return;
    }

    // تهيئة مصفوفة الإجابات
    answers = questions.map(q => ({
      question_id: q.id,
      selected_option_ids: []
    }));

    qTotal.textContent = totalQuestions;

    quizLoading.style.display = 'none';
    questionView.style.display = 'block';

    buildMiniPath();
    renderQuestion();
    updateFinishState();

  } catch (error) {
    console.error('Error loading questions:', error);
    quizLoading.innerHTML = `
      <div class="quiz-empty-state">
        <p>فشل الاتصال بالخادم. يرجى المحاولة لاحقاً.</p>
      </div>
    `;
  }
}

/* ======================= RENDER LOGIC ======================= */
function buildMiniPath() {
  miniPath.innerHTML = '';
  questions.forEach((_, i) => {
    const dot = document.createElement('span');
    dot.className = 'mini-dot';
    dot.dataset.index = i;
    miniPath.appendChild(dot);
  });
}

function updateMiniPath() {
  const dots = miniPath.querySelectorAll('.mini-dot');
  dots.forEach((dot, i) => {
    dot.classList.remove('done', 'active');
    if (i < current) dot.classList.add('done');
    else if (i === current) dot.classList.add('active');
  });
}

function updateRing() {
  if (!questions.length) return;
  const pct = Math.round(((current + 1) / questions.length) * 100);
  ringWrap.style.setProperty('--progress', pct);
}

function renderQuestion() {
  const q = questions[current];
  qNum.textContent = current + 1;
  qText.textContent = q.text;

  qOptions.className = 'quiz-options' + (q.options.length === 2 ? ' two-options' : '');

  const currentAns = answers[current] || { question_id: q.id, selected_option_ids: [] };
  const selectedIds = currentAns.selected_option_ids || [];

  qOptions.innerHTML = '';
  q.options.forEach((opt) => {
    const isSelected = selectedIds.includes(opt.id);
    const el = document.createElement('div');
    el.className = 'quiz-option' + (isSelected ? ' selected' : '');
    el.innerHTML = '<span>' + opt.text + '</span><span class="opt-check"></span>';

    el.addEventListener('click', () => {
      let newSelected = [...selectedIds];
      if (newSelected.includes(opt.id)) {
        // إلغاء الاختيار
        newSelected = newSelected.filter(id => id !== opt.id);
      } else {
        if (newSelected.length < 2) {
          // إضافة الاختيار الثاني
          newSelected.push(opt.id);
        } else {
          // محاولة اختيار خيار ثالث وتجاوز الحد الأقصى
          showLimitToast('يمكنك اختيار إجابتين كحد أقصى لهذا السؤال');
          return;
        }
      }

      answers[current] = {
        question_id: q.id,
        selected_option_ids: newSelected
      };

      spawnBurst(el);
      renderQuestion();
      updateFinishState();
    });

    qOptions.appendChild(el);
  });

  btnPrev.disabled = (current === 0);
  btnNext.style.display = (current === questions.length - 1) ? 'none' : 'inline-flex';

  updateMiniPath();
  updateRing();
}

function updateFinishState() {
  // زر إنهاء الاختبار يتفعل عندما يمتلك كل سؤال إجابة واحدة على الأقل
  const allAnswered = answers.every(a => a && a.selected_option_ids && a.selected_option_ids.length >= 1);
  btnFinish.disabled = !allAnswered;
}

/* ======================= ANIMATIONS ======================= */
function spawnBurst(targetEl) {
  const rect = targetEl.getBoundingClientRect();
  const cardRect = quizCard.getBoundingClientRect();
  const originX = rect.left - cardRect.left + rect.width / 2;
  const originY = rect.top - cardRect.top + rect.height / 2;

  for (let i = 0; i < 10; i++) {
    const dot = document.createElement('span');
    dot.className = 'burst-dot';
    const angle = (Math.PI * 2 * i) / 10 + Math.random() * 0.4;
    const dist = 34 + Math.random() * 26;
    const fx = Math.cos(angle) * dist;
    const fy = Math.sin(angle) * dist;
    dot.style.left = originX + 'px';
    dot.style.top = originY + 'px';
    dot.style.background = brandColors[i % brandColors.length];
    dot.style.setProperty('--fly', 'translate(' + fx + 'px,' + fy + 'px)');
    quizCard.appendChild(dot);
    dot.addEventListener('animationend', () => dot.remove());
  }
}

function spawnConfetti() {
  const cardWidth = quizCard.clientWidth;
  for (let i = 0; i < 36; i++) {
    const piece = document.createElement('span');
    piece.className = 'confetti-piece';
    const startX = Math.random() * cardWidth;
    const fallY = 220 + Math.random() * 140;
    const driftX = (Math.random() - 0.5) * 120;
    piece.style.left = startX + 'px';
    piece.style.background = brandColors[i % brandColors.length];
    piece.style.setProperty('--fall', 'translate(' + driftX + 'px,' + fallY + 'px)');
    piece.style.setProperty('--spin', (Math.random() * 480 - 240) + 'deg');
    piece.style.animationDelay = (Math.random() * 0.3) + 's';
    quizCard.appendChild(piece);
    piece.addEventListener('animationend', () => piece.remove());
  }
}

/* ======================= EVENT LISTENERS ======================= */
btnPrev.addEventListener('click', () => {
  if (current > 0) { current--; renderQuestion(); }
});

btnNext.addEventListener('click', () => {
  if (current < questions.length - 1) { current++; renderQuestion(); }
});

btnFinish.addEventListener('click', async () => {
  if (btnFinish.disabled) return;

  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

  btnFinish.disabled = true;
  btnFinish.innerHTML = 'جاري حفظ الإجابات وتحليل النتائج... <div class="quiz-spinner" style="width:16px;height:16px;border-width:2px;display:inline-block;vertical-align:middle;margin-inline-start:6px;"></div>';

  try {
    // 1) حفظ الإجابات بجدول student_survey_responses
    const saveResp = await fetch('/quiz/responses', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify({
        interest_id: currentInterestId,
        attempt_token: attemptToken,
        answers: answers
      })
    });

    const saveData = await saveResp.json();

    if (!saveResp.ok || saveData.status !== 'success') {
      alert(saveData.message || 'حدث خطأ أثناء حفظ الإجابات. يرجى المحاولة مرة أخرى.');
      updateFinishState();
      btnFinish.innerHTML = 'إنهاء الاختبار <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg>';
      return;
    }

    // 2) توليد نتائج التوصيات احتساباً وتخزينها في recommendation_results
    const recommendationsResp = await fetch('/quiz/generate-recommendations', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      }
    });
    const recommendationsData = await recommendationsResp.json();

    if (!recommendationsResp.ok || recommendationsData.status !== 'success') {
      throw new Error(recommendationsData.message || 'تعذر توليد التوصيات.');
    }

    // 3) إظهار شاشة الانتهاء وتفعيل الـ Confetti
    questionView.style.display = 'none';
    doneView.style.display = 'block';
    ringWrap.classList.add('complete');
    spawnConfetti();

  } catch (error) {
    console.error('Error submitting quiz:', error);
    alert('فشل الاتصال بالخادم عند حفظ الإجابات.');
    updateFinishState();
    btnFinish.innerHTML = 'إنهاء الاختبار <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6L9 17l-5-5"/></svg>';
  }
});

/* Init */
document.addEventListener('DOMContentLoaded', loadQuestions);
</script>
@endsection
