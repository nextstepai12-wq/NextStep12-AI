<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>استعراض العمادات والتخصصات — لوحة تحكم الإدارة | NextStep AI</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- ====== CSS ====== -->
  <link rel="stylesheet" href="{{ asset('Front_end/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/admin-shell.css') }}">
  <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/programs.css') }}">
  <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/browsedeanships.css') }}">

  <!-- CSRF Token لطلبات AJAX -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!-- ======================= TOP BAR ======================= -->
<header class="admin-topbar" id="adminTopbar"></header>

<!-- ======================= LAYOUT ======================= -->
<div class="admin-layout">

  <!-- ====== SIDEBAR ====== -->
  <aside class="admin-sidebar" id="adminSidebar"></aside>

  <!-- ====== MAIN CONTENT ====== -->
  <main class="admin-main admin-main-content">

    <!-- ====== PAGE HEADER ====== -->
    <div class="admin-page-head">
      <div>
        <h1>استعراض العمادات والتخصصات</h1>
        <p>تصفّحي كل العمادات المسجّلة، ادخلي على أي عمادة لعرض تخصصاتها، وبضغطة وحدة شوفي الخطة الدراسية الكاملة لأي تخصص.</p>
      </div>
    </div>

    <!-- ====== STEPPER ====== -->
    <div class="admin-steps" id="stepsRow">
      <button type="button" class="admin-step-card active" data-step="1" id="stepBtn1">
        <span class="step-label">العمادات<br><small>الخطوة الأولى</small></span>
        <span class="step-num">1</span>
      </button>
      <button type="button" class="admin-step-card" data-step="2" id="stepBtn2">
        <span class="step-label">التخصصات<br><small>الخطوة الثانية</small></span>
        <span class="step-num">2</span>
      </button>
      <button type="button" class="admin-step-card" data-step="3" id="stepBtn3">
        <span class="step-label">الخطة الدراسية<br><small>الخطوة الثالثة</small></span>
        <span class="step-num">3</span>
      </button>
    </div>

    <!-- ====== BREADCRUMB TRAIL ====== -->
    <div class="browse-trail" id="browseTrail"></div>

    <!-- =========================================================
         STEP 1 — DEANSHIPS (يُعرض من السيرفر مباشرة)
    ========================================================== -->
    <section class="browse-step active" id="stepDeanships">

      <div class="admin-panel">

        <div class="browse-search">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="7"/>
            <path d="M21 21l-4.3-4.3"/>
          </svg>
          <input type="text" id="deanshipSearchInput" placeholder="ابحثي عن عمادة...">
        </div>

        <div class="deanship-grid" id="deanshipGrid">
          @forelse ($deanships as $index => $deanship)
            <div class="deanship-card"
                 data-id="{{ $deanship->id }}"
                 data-name="{{ $deanship->name }}"
                 data-dean="{{ $deanship->dean_name ?? '' }}"
                 data-majors-count="{{ $deanship->majors_count }}">
              <div class="deanship-card-top">
                <div class="deanship-logo c{{ (($index) % 5) + 1 }}">
                    {{ mb_substr(str_replace('عمادة', '', $deanship->name), 0, 2) }}
                </div>
                <div>
                  <h4>{{ $deanship->name }}</h4>
                  @if ($deanship->dean_name)
                    <div class="dean-name">{{ $deanship->dean_name }}</div>
                  @endif
                </div>
              </div>
              <div class="deanship-card-footer">
                <span class="majors-count-badge">{{ $deanship->majors_count }} تخصص</span>
                <span class="deanship-card-arrow">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 18l-6-6 6-6"/></svg>
                </span>
              </div>
            </div>
          @empty
            <p style="color:#6b6f80;font-size:13.5px;">ما في عمادات مسجّلة بعد. أضيفي عمادة جديدة من صفحة إدارة العمادات.</p>
          @endforelse
        </div>

      </div>

    </section>

    <!-- =========================================================
         STEP 2 — MAJORS (يُحمّل عبر AJAX عند اختيار عمادة)
    ========================================================== -->
    <section class="browse-step" id="stepMajors">

      <div class="admin-panel">
        <h3 style="font-size:15px;font-weight:700;margin-bottom:16px;" id="majorsPanelTitle">تخصصات العمادة</h3>
        <div class="major-grid" id="majorGrid">
          <!-- يتم تعبئتها عبر AJAX -->
        </div>
      </div>

    </section>

    <!-- =========================================================
         STEP 3 — STUDY PLAN (مُعلّق موقتاً — سيُضاف لاحقاً)
    ========================================================== -->
    <section class="browse-step" id="stepPlan">

      <div class="admin-panel">
        <div class="plan-head">
          <div>
            <h2 id="planMajorName">—</h2>
            <div class="plan-sub" id="planMajorSub">—</div>
          </div>
          <div class="plan-actions" id="planActions">
            <button type="button" class="plan-action-btn" id="editMajorBtn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/>
              </svg>
              تعديل البيانات الأساسية
            </button>
            <button type="button" class="plan-action-btn" id="updatePlanBtn">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <path d="M17 8l-5-5-5 5"/>
                <path d="M12 3v12"/>
              </svg>
              تحديث الخطة الدراسية
            </button>
            <button type="button" class="plan-download-btn" id="planDownloadBtn">
              <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <path d="M7 10l5 5 5-5"/>
                <path d="M12 15V3"/>
              </svg>
              عرض الملف الأصلي المرفوع
            </button>
          </div>
        </div>

        <div class="empty-plan-hint" id="planContentPlaceholder">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 9v4M12 17h.01"/><circle cx="12" cy="12" r="10"/>
          </svg>
          عرض الخطة الدراسية سيكون متاحاً قريباً.
        </div>

      </div>

    </section>

  </main>
</div>

<!-- ======================= MODAL ======================= -->
<div class="app-modal-overlay" id="appModalOverlay">
  <div class="app-modal" role="alertdialog" aria-modal="true" aria-labelledby="appModalTitle" aria-describedby="appModalMsg">
    <div class="app-modal-icon" id="appModalIcon"></div>
    <h3 class="app-modal-title" id="appModalTitle"></h3>
    <p class="app-modal-msg" id="appModalMsg"></p>
    <div class="app-modal-actions" id="appModalActions"></div>
  </div>
</div>

<!-- ======================= SCRIPTS ======================= -->
<script>
(function () {
  'use strict';

  /* ============================================================
     ثوابت
  ============================================================= */
  const AJAX_URL = '{{ route("university.browse.majors", ["deanshipFaculty" => "__ID__"]) }}'.replace('__ID__', '');
  const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  /* ============================================================
     MODAL
  ============================================================= */
  const modalOverlay = document.getElementById('appModalOverlay');
  const modalIcon    = document.getElementById('appModalIcon');
  const modalTitle   = document.getElementById('appModalTitle');
  const modalMsg     = document.getElementById('appModalMsg');
  const modalActions = document.getElementById('appModalActions');

  const MODAL_ICONS = {
    success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>',
    error:   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>',
    info:    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>'
  };

  function closeModal() { modalOverlay.classList.remove('is-open'); }

  function openModal({ type = 'info', title = '', message = '', confirmText = 'تمام' }) {
    modalIcon.className = 'app-modal-icon ' + type;
    modalIcon.innerHTML = MODAL_ICONS[type] || MODAL_ICONS.info;
    modalTitle.textContent = title;
    modalMsg.textContent   = message;
    modalActions.innerHTML = '';

    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'app-modal-btn';
    btn.textContent = confirmText;
    btn.addEventListener('click', closeModal);
    modalActions.appendChild(btn);

    modalOverlay.classList.add('is-open');
  }

  modalOverlay.addEventListener('click', function (e) {
    if (e.target === modalOverlay) closeModal();
  });

  /* ============================================================
     STATE
  ============================================================= */
  let currentDeanship = null;
  let currentMajor    = null;

  /* ============================================================
     TRAIL (Breadcrumb)
  ============================================================= */
  function renderTrail() {
    const trail = document.getElementById('browseTrail');
    trail.innerHTML = '';

    const rootBtn = document.createElement(currentDeanship ? 'button' : 'span');
    rootBtn.textContent = 'العمادات';
    if (currentDeanship) {
      rootBtn.addEventListener('click', () => goToStep(1));
    } else {
      rootBtn.className = 'trail-current';
    }
    trail.appendChild(rootBtn);

    if (currentDeanship) {
      trail.insertAdjacentHTML('beforeend', arrowSvg());
      const deanBtn = document.createElement(currentMajor ? 'button' : 'span');
      deanBtn.textContent = currentDeanship.name;
      if (currentMajor) {
        deanBtn.addEventListener('click', () => goToStep(2));
      } else {
        deanBtn.className = 'trail-current';
      }
      trail.appendChild(deanBtn);
    }

    if (currentMajor) {
      trail.insertAdjacentHTML('beforeend', arrowSvg());
      const majorSpan = document.createElement('span');
      majorSpan.className = 'trail-current';
      majorSpan.textContent = currentMajor.title;
      trail.appendChild(majorSpan);
    }
  }

  function arrowSvg() {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 18l-6-6 6-6"/></svg>';
  }

  /* ============================================================
     STEP NAVIGATION
  ============================================================= */
  const stepSections = {
    1: document.getElementById('stepDeanships'),
    2: document.getElementById('stepMajors'),
    3: document.getElementById('stepPlan')
  };
  const stepButtons = {
    1: document.getElementById('stepBtn1'),
    2: document.getElementById('stepBtn2'),
    3: document.getElementById('stepBtn3')
  };

  function goToStep(step) {
    if (step >= 2 && !currentDeanship) return;
    if (step >= 3 && !currentMajor) return;

    Object.keys(stepSections).forEach(k => {
      stepSections[k].classList.toggle('active', Number(k) === step);
      stepButtons[k].classList.toggle('active', Number(k) === step);
    });

    if (step === 1) { currentMajor = null; }
    if (step === 2) { currentMajor = null; }

    renderTrail();
  }

  stepButtons[1].addEventListener('click', () => goToStep(1));
  stepButtons[2].addEventListener('click', () => goToStep(2));
  stepButtons[3].addEventListener('click', () => { if (currentMajor) goToStep(3); });

  /* ============================================================
     STEP 1 — DEANSHIPS (مُعرضة من السيرفر — بحث محلي فقط)
  ============================================================= */
  const deanshipGrid = document.getElementById('deanshipGrid');

  // ربط أحداث الضغط على كروت العمادات المُعرضة من Blade
  deanshipGrid.querySelectorAll('.deanship-card').forEach(card => {
    card.addEventListener('click', () => {
      selectDeanship({
        id:    parseInt(card.dataset.id),
        name:  card.dataset.name,
        dean:  card.dataset.dean,
        count: parseInt(card.dataset.majorsCount)
      });
    });
  });

  // بحث محلي بين العمادات المُعرضة
  document.getElementById('deanshipSearchInput').addEventListener('input', function () {
    const keyword = this.value.trim().toLowerCase();
    deanshipGrid.querySelectorAll('.deanship-card').forEach(card => {
      const name  = card.dataset.name.toLowerCase();
      const dean  = card.dataset.dean.toLowerCase();
      card.style.display = (!keyword || name.includes(keyword) || dean.includes(keyword))
        ? '' : 'none';
    });

    // إظهار رسالة "ما في نتائج" لو كل الكروت مخفية
    const visibleCards = deanshipGrid.querySelectorAll('.deanship-card:not([style*="display: none"])');
    let noResult = deanshipGrid.querySelector('.no-results-msg');
    if (visibleCards.length === 0 && keyword) {
      if (!noResult) {
        noResult = document.createElement('p');
        noResult.className = 'no-results-msg';
        noResult.style.cssText = 'color:#6b6f80;font-size:13.5px;';
        noResult.textContent = 'ما في نتائج مطابقة لبحثك.';
        deanshipGrid.appendChild(noResult);
      }
    } else if (noResult) {
      noResult.remove();
    }
  });

  async function selectDeanship(deanship) {
    currentDeanship = deanship;
    currentMajor    = null;
    document.getElementById('majorsPanelTitle').textContent = `تخصصات ${deanship.name}`;

    // إظهار حالة التحميل
    const majorGrid = document.getElementById('majorGrid');
    majorGrid.innerHTML = '<p style="color:#6b6f80;font-size:13.5px;text-align:center;padding:24px 0;">جاري تحميل التخصصات...</p>';

    goToStep(2);

    try {
      const url = '{{ route("university.browse.majors", ["deanshipFaculty" => "__ID__"]) }}'.replace('__ID__', deanship.id);
      const response = await fetch(url, {
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': CSRF_TOKEN
        }
      });

      if (!response.ok) throw new Error('فشل في تحميل التخصصات');

      const data = await response.json();
      renderMajors(data.majors);
    } catch (err) {
      majorGrid.innerHTML = '<p style="color:#e74c3c;font-size:13.5px;">حصل خطأ أثناء تحميل التخصصات. حاولي مرة ثانية.</p>';
      console.error('Browse majors error:', err);
    }
  }

  /* ============================================================
     STEP 2 — MAJORS (يُعرض من AJAX)
  ============================================================= */
  function renderMajors(majors) {
    const majorGrid = document.getElementById('majorGrid');
    majorGrid.innerHTML = '';

    if (!majors.length) {
      majorGrid.innerHTML = '<p style="color:#6b6f80;font-size:13.5px;">ما في تخصصات مضافة تحت هاي العمادة بعد.</p>';
      return;
    }

    majors.forEach(m => {
      const hasPlan = !!(m.study_plan_image || m.study_plan_file_url);
      const card = document.createElement('div');
      card.className = 'major-card';
      card.dataset.id      = m.id;
      card.dataset.title    = m.title;
      card.dataset.hasPlan  = hasPlan ? '1' : '0';
      card.dataset.planFile = m.study_plan_file_url || '';
      card.dataset.planImg  = m.study_plan_image || '';
      card.dataset.hours    = m.total_credit_hours || 0;
      card.innerHTML = `
        <div class="major-card-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
        </div>
        <h5>${m.title}</h5>
        <div class="major-meta">
          <span>${m.total_credit_hours || '—'} ساعة معتمدة</span>
        </div>
      `;
      card.addEventListener('click', () => selectMajor({
        id:              m.id,
        title:           m.title,
        hasPlan:         hasPlan,
        studyPlanFile:   m.study_plan_file_url,
        studyPlanImage:  m.study_plan_image,
        totalCreditHours: m.total_credit_hours
      }));
      majorGrid.appendChild(card);
    });
  }

  function selectMajor(major) {
    currentMajor = major;
    renderPlanPlaceholder(major);
    goToStep(3);
  }

  /* ============================================================
     STEP 3 — PLACEHOLDER (الخطة الدراسية مو متوفرة الحين)
  ============================================================= */
  function renderPlanPlaceholder(major) {
    document.getElementById('planMajorName').textContent = major.title;
    document.getElementById('planMajorSub').textContent =
      `${currentDeanship.name} • ${major.totalCreditHours || '—'} ساعة معتمدة`;

    const placeholder = document.getElementById('planContentPlaceholder');
    if (major.hasPlan) {
      placeholder.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 9v4M12 17h.01"/><circle cx="12" cy="12" r="10"/>
        </svg>
        يوجد خطة دراسية مرفقة لهذا التخصص — عرض الخطة سيكون متاحاً قريباً.
        ${major.studyPlanFile
          ? `<br><a href="${major.studyPlanFile}" target="_blank" style="color:var(--accent,#6366f1);text-decoration:underline;margin-top:8px;display:inline-block;">فتح ملف الخطة المرفوع</a>`
          : ''}
      `;
    } else {
      placeholder.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 9v4M12 17h.01"/><circle cx="12" cy="12" r="10"/>
        </svg>
        ما تم رفع خطة دراسية لهذا التخصص بعد.
      `;
    }
  }

  /* ============================================================
     أزرار الخطوة 3
  ============================================================= */
  document.getElementById('editMajorBtn').addEventListener('click', function () {
    if (!currentMajor) return;
    window.location.href = `{{ route('university.Majors') }}?edit=${currentMajor.id}`;
  });

  document.getElementById('updatePlanBtn').addEventListener('click', function () {
    if (!currentDeanship || !currentMajor) return;
    window.location.href = `{{ route('university.Majors') }}?deanship=${currentDeanship.id}&major=${currentMajor.id}`;
  });

  document.getElementById('planDownloadBtn').addEventListener('click', function () {
    if (!currentMajor) return;
    if (currentMajor.studyPlanFile) {
      window.open(currentMajor.studyPlanFile, '_blank');
    } else {
      openModal({
        type: 'info',
        title: 'عرض الملف الأصلي',
        message: 'ما في ملف خطة دراسية مرفوع لهذا التخصص.'
      });
    }
  });

  /* ============================================================
     INIT
  ============================================================= */
  renderTrail();

})();
</script>

<div id="admin-footer-slot"></div>
<script src="{{ asset('Front_end/js/admin-shell.js') }}"></script>

</body>
</html>