<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>خطة {{ $studyPlan->major->title ?? 'التخصص' }} ({{ $studyPlan->academic_year }}) | NextStep AI</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- ====== CSS ====== -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardcss/admin-shell.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardcss/programs.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardcss/browsedeanships.css') }}">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    :root {
      --primary: #2F6BFF;
      --primary-dark: #1E40AF;
      --primary-light: rgba(47,107,255,0.08);
      --navy: #0F172A;
      --slate: #334155;
      --gray-sub: #64748B;
      --bg-card: #FFFFFF;
      --border-subtle: #E2E8F0;
      --green-accent: #10B981;
      --green-light: rgba(16,185,129,0.1);
      --gold-accent: #F59E0B;
      --gold-light: rgba(245,158,11,0.1);
      --red-accent: #EF4444;
      --red-light: rgba(239,68,68,0.1);
      --purple-accent: #8B5CF6;
      --purple-light: rgba(139,92,246,0.1);
    }

    body {
      font-family: 'Cairo', sans-serif;
      background-color: #F8FAFC;
      color: var(--slate);
    }

    /* إخفاء عناصر البحث الموك غير الضرورية في الشريط العلوي */
    .admin-search {
      display: none !important;
    }

    .plan-container {
      max-width: 1300px;
      margin: 0 auto;
      padding-bottom: 60px;
    }

    /* بطاقة الرأس والبيانات الأساسية */
    .plan-header-card {
      background: #FFFFFF;
      border-radius: 16px;
      padding: 26px 30px;
      border: 1px solid var(--border-subtle);
      box-shadow: 0 4px 20px -4px rgba(15,23,42,0.05);
      margin-bottom: 24px;
    }

    .plan-header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      padding-bottom: 20px;
      border-bottom: 1px solid var(--border-subtle);
    }

    .plan-main-title {
      font-size: 1.55rem;
      font-weight: 800;
      color: var(--navy);
      margin: 0 0 6px 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .plan-meta-tags {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
      font-size: 0.88rem;
      color: var(--gray-sub);
    }

    .meta-chip {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #F1F5F9;
      padding: 4px 12px;
      border-radius: 20px;
      font-weight: 600;
      color: var(--navy);
    }

    .status-confirmed-chip {
      background: var(--green-light);
      color: var(--green-accent);
    }

    .status-draft-chip {
      background: var(--gold-light);
      color: var(--gold-accent);
    }

    .plan-action-bar {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .btn-custom {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 9px 18px;
      border-radius: 10px;
      font-size: 0.92rem;
      font-weight: 700;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease;
      border: none;
      font-family: inherit;
    }

    .btn-edit-mode {
      background: linear-gradient(135deg, #2563EB, #1D4ED8);
      color: #FFFFFF;
      box-shadow: 0 4px 14px rgba(37,99,235,0.25);
    }
    .btn-edit-mode:hover {
      background: linear-gradient(135deg, #1D4ED8, #1E40AF);
      transform: translateY(-1px);
    }

    .btn-save-confirm {
      background: linear-gradient(135deg, #10B981, #059669);
      color: #FFFFFF;
      box-shadow: 0 4px 14px rgba(16,185,129,0.25);
    }
    .btn-save-confirm:hover {
      background: linear-gradient(135deg, #059669, #047857);
      transform: translateY(-1px);
    }

    .btn-cancel {
      background: #F1F5F9;
      color: var(--slate);
      border: 1px solid var(--border-subtle);
    }
    .btn-cancel:hover {
      background: #E2E8F0;
    }

    .btn-back {
      background: #FFFFFF;
      color: var(--slate);
      border: 1px solid var(--border-subtle);
    }
    .btn-back:hover {
      background: #F8FAFC;
    }

    /* شبكة الإحصائيات */
    .plan-stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
      gap: 16px;
      margin-top: 20px;
    }

    .plan-stat-box {
      background: #F8FAFC;
      border-radius: 12px;
      padding: 14px 18px;
      border: 1px solid #EEF2F6;
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .stat-icon-wrapper {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .stat-num {
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--navy);
      line-height: 1.2;
    }

    .stat-label {
      font-size: 0.8rem;
      color: var(--gray-sub);
      font-weight: 600;
    }

    /* تنبيهات الذكاء الاصطناعي القابلة للطي */
    .ai-notice-accordion {
      background: #FFFBEB;
      border: 1px solid #FDE68A;
      border-radius: 12px;
      margin-bottom: 24px;
      overflow: hidden;
    }

    .ai-notice-header {
      padding: 14px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
      font-weight: 700;
      color: #92400E;
      user-select: none;
    }

    .ai-notice-content {
      padding: 0 20px 16px 20px;
      font-size: 0.88rem;
      color: #78350F;
      line-height: 1.7;
    }

    .ai-notice-content ul {
      margin: 0;
      padding-right: 20px;
    }

    /* شريط التنبيه عند تفعيل وضع التعديل */
    .edit-mode-banner {
      display: none;
      background: #EFF6FF;
      border: 1px solid #BFDBFE;
      color: #1E40AF;
      border-radius: 12px;
      padding: 14px 20px;
      margin-bottom: 24px;
      font-weight: 600;
      font-size: 0.92rem;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    /* كروت السنوات والفصول */
    .year-section {
      margin-top: 32px;
    }

    .year-title {
      font-size: 1.22rem;
      font-weight: 800;
      color: var(--navy);
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
      padding-bottom: 8px;
      border-bottom: 2px solid #E2E8F0;
    }

    .semester-card {
      background: #FFFFFF;
      border-radius: 14px;
      border: 1px solid var(--border-subtle);
      box-shadow: 0 2px 10px rgba(15,23,42,0.03);
      margin-bottom: 20px;
      overflow: hidden;
    }

    .semester-header {
      background: #F8FAFC;
      padding: 14px 22px;
      border-bottom: 1px solid var(--border-subtle);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .semester-title {
      font-size: 1rem;
      font-weight: 700;
      color: var(--navy);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .sem-badge {
      background: var(--navy);
      color: white;
      font-size: 0.75rem;
      padding: 2px 8px;
      border-radius: 6px;
      font-weight: 700;
    }

    /* جداول المساقات */
    .plan-table {
      width: 100%;
      border-collapse: collapse;
      text-align: right;
    }

    .plan-table th {
      background: #FAFAFC;
      padding: 12px 18px;
      font-size: 0.82rem;
      font-weight: 700;
      color: var(--gray-sub);
      border-bottom: 1px solid var(--border-subtle);
      white-space: nowrap;
    }

    .plan-table td {
      padding: 12px 18px;
      font-size: 0.9rem;
      color: var(--slate);
      border-bottom: 1px solid #F1F5F9;
      vertical-align: middle;
    }

    .plan-table tbody tr:last-child td {
      border-bottom: none;
    }

    .plan-table tbody tr:hover {
      background-color: #F8FAFC;
    }

    /* أنماط الحقول في وضع العرض */
    .course-code-badge {
      display: inline-block;
      background: #F1F5F9;
      color: var(--navy);
      font-weight: 800;
      font-family: 'Poppins', sans-serif;
      padding: 4px 10px;
      border-radius: 6px;
      border: 1px solid #E2E8F0;
      letter-spacing: 0.5px;
      font-size: 0.85rem;
    }

    .course-name-text {
      font-weight: 700;
      color: var(--navy);
    }

    .hours-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: rgba(47,107,255,0.07);
      color: #2563EB;
      padding: 4px 10px;
      border-radius: 6px;
      font-weight: 800;
      font-size: 0.88rem;
    }

    .type-badge {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 0.78rem;
      font-weight: 700;
    }
    .type-specialization { background: rgba(47,107,255,0.1); color: #2563EB; }
    .type-college { background: rgba(139,92,246,0.1); color: #7C3AED; }
    .type-university { background: rgba(16,185,129,0.1); color: #059669; }

    .prereq-badge {
      display: inline-block;
      background: #F1F5F9;
      color: var(--slate);
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 0.78rem;
      font-weight: 700;
      font-family: 'Poppins', sans-serif;
      margin-left: 4px;
    }

    /* حقول الإدخال في وضع التعديل */
    .edit-field {
      display: none;
    }

    .edit-mode-active .view-field {
      display: none !important;
    }

    .edit-mode-active .edit-field {
      display: block !important;
    }

    .edit-mode-active .edit-mode-banner {
      display: flex !important;
    }

    .edit-mode-active .view-actions {
      display: none !important;
    }

    .edit-mode-active .edit-actions {
      display: flex !important;
    }

    .edit-actions {
      display: none;
      align-items: center;
      gap: 10px;
    }

    .input-form-control {
      width: 100%;
      padding: 7px 12px;
      border: 1px solid #CBD5E1;
      border-radius: 8px;
      font-family: inherit;
      font-size: 0.88rem;
      color: var(--navy);
      background: #FFFFFF;
      transition: all 0.2s;
      box-sizing: border-box;
    }

    .input-form-control:focus {
      outline: none;
      border-color: #2563EB;
      box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
      background: #FFFFFF;
    }

    .input-hours {
      width: 80px;
      text-align: center;
      font-weight: 700;
    }

    .btn-delete-row {
      background: none;
      border: none;
      color: #EF4444;
      cursor: pointer;
      padding: 6px;
      border-radius: 6px;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-delete-row:hover {
      background: rgba(239,68,68,0.1);
    }

    .add-course-btn {
      display: none;
      align-items: center;
      justify-content: center;
      gap: 6px;
      width: 100%;
      padding: 10px;
      background: #F8FAFC;
      border: 1px dashed #CBD5E1;
      border-top: none;
      color: #2563EB;
      font-weight: 700;
      font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.2s;
    }
    .add-course-btn:hover {
      background: #EFF6FF;
      border-color: #93C5FD;
    }

    .edit-mode-active .add-course-btn {
      display: flex !important;
    }

    .floating-save-bar {
      display: none;
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(15,23,42,0.92);
      backdrop-filter: blur(8px);
      padding: 12px 24px;
      border-radius: 50px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.25);
      z-index: 1000;
      align-items: center;
      gap: 16px;
      color: white;
    }

    .edit-mode-active .floating-save-bar {
      display: flex !important;
    }
  </style>
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
    <div class="plan-container" id="planMainContainer">

      <!-- ====== BREADCRUMB ====== -->
      <div class="browse-trail" style="margin-bottom: 18px;">
        <a href="{{ route('university.study-plans.index') }}" style="color: var(--gray-sub); text-decoration: none; font-weight: 600;">الخطط الدراسية</a>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width: 16px; height: 16px; margin: 0 4px;"><path d="M15 18l-6-6 6-6"/></svg>
        <span class="trail-current" style="color: var(--navy); font-weight: 700;">{{ $studyPlan->major->title ?? 'التخصص' }}</span>
      </div>

      <!-- ====== MESSAGES ====== -->
      @if (session('status'))
        <div style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; border-radius: 12px; padding: 14px 20px; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 20px; height: 20px; color: #10B981;"><path d="M20 6L9 17l-5-5"/></svg>
          {{ session('status') }}
        </div>
      @endif

      @if (!empty($validation['errors']))
        <div style="background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px;">
          <div style="font-weight: 800; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width: 20px; height: 20px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            تنبيه: تم العثور على أخطاء يجب معالجتها قبل التأكيد:
          </div>
          <ul style="margin: 0; padding-right: 22px; font-size: 0.88rem; line-height: 1.6;">
            @foreach ($validation['errors'] as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- تنبيهات الذكاء الاصطناعي (أكورديون قابل للطي) -->
      @if (!empty($validation['warnings']))
        <div class="ai-notice-accordion">
          <div class="ai-notice-header" onclick="toggleAiNotice()">
            <div style="display: flex; align-items: center; gap: 8px;">
              <span>💡</span>
              <span>ملاحظات استرشادية من الذكاء الاصطناعي ({{ count($validation['warnings']) }} ملاحظة)</span>
            </div>
            <svg id="aiNoticeChevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 18px; height: 18px; transition: transform 0.2s;"><path d="M6 9l6 6 6-6"/></svg>
          </div>
          <div class="ai-notice-content" id="aiNoticeContent" style="display: none;">
            <ul>
              @foreach ($validation['warnings'] as $warn)
                <li>{{ $warn }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif

      @php
        // تجهيز بيانات السنوات والمقررات
        $extractedData = $studyPlan->raw_extracted_data['data'] ?? null;
        $yearsData = $extractedData['years'] ?? [];

        // في حال كانت الخطة محفوظة مسبقاً في الجداول
        if (empty($yearsData) && $studyPlan->studyPlanCourses->count() > 0) {
          $groupedYears = $studyPlan->studyPlanCourses->groupBy('year_number');
          foreach ($groupedYears as $yNum => $coursesInY) {
            $semesters = [];
            foreach ($coursesInY->groupBy('semester_number') as $sNum => $coursesInS) {
              $cList = [];
              foreach ($coursesInS as $spcItem) {
                $cList[] = [
                  'course_code' => $spcItem->course->code ?? '',
                  'course_name_ar' => $spcItem->course->name_ar ?? '',
                  'credit_hours' => [
                    'total' => $spcItem->course->default_total_hours ?? 3,
                    'theory' => $spcItem->course->default_theory_hours ?? 3,
                    'practical' => $spcItem->course->default_practical_hours ?? 0,
                  ],
                  'course_type' => $spcItem->course->default_type ?? 'specialization',
                  'prerequisites' => $spcItem->prerequisites->pluck('prerequisite_code')->toArray(),
                ];
              }
              $semesters[] = [
                'semester_number' => (int)$sNum,
                'courses' => $cList,
              ];
            }
            $yearsData[] = [
              'year_number' => (int)$yNum,
              'semesters' => $semesters,
            ];
          }
        }

        $calcTotalSemesters = 0;
        $calcTotalCourses = 0;
        $calcTotalHours = 0;

        foreach($yearsData as $y) {
          $semesters = $y['semesters'] ?? [];
          $calcTotalSemesters += count($semesters);
          foreach($semesters as $s) {
            $courses = $s['courses'] ?? [];
            $calcTotalCourses += count($courses);
            foreach($courses as $c) {
              $h = $c['credit_hours'] ?? 0;
              $calcTotalHours += is_numeric($h) ? (int)$h : (int)($h['total'] ?? 0);
            }
          }
        }
      @endphp

      <!-- FORM START -->
      <form action="{{ route('university.study-plans.confirm', $studyPlan) }}" method="POST" id="mainPlanForm">
        @csrf

        <!-- ====== HEADER CARD ====== -->
        <div class="plan-header-card">
          <div class="plan-header-top">
            <div>
              <h1 class="plan-main-title">
                {{ $studyPlan->major->title ?? 'خطة البرنامج الأكاديمي' }}
              </h1>
              <div class="plan-meta-tags">
                <span class="meta-chip">
                  <span>📅 سنة الاعتماد:</span>
                  <strong>{{ $studyPlan->academic_year }}</strong>
                </span>
                @if($studyPlan->version_label)
                  <span class="meta-chip">
                    <span>🏷️ الإصدار:</span>
                    <strong>{{ $studyPlan->version_label }}</strong>
                  </span>
                @endif
                @if($studyPlan->status === 'confirmed')
                  <span class="meta-chip status-confirmed-chip">
                    <span>✓</span>
                    <span>معتمدة ومحفوظة</span>
                  </span>
                @else
                  <span class="meta-chip status-draft-chip">
                    <span>⚡</span>
                    <span>مسودة بانتظار التأكيد</span>
                  </span>
                @endif
              </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="plan-action-bar">
              <!-- عرض أزرار وضع المشاهدة -->
              <div class="view-actions" style="display: flex; gap: 10px;">
                <a href="{{ route('university.study-plans.index') }}" class="btn-custom btn-back">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                  رجوع للقائمة
                </a>
                <button type="button" class="btn-custom btn-edit-mode" onclick="enableEditMode()">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                  تعديل الخطة
                </button>
                @if($studyPlan->status !== 'confirmed')
                  <button type="submit" class="btn-custom btn-save-confirm" onclick="return confirm('هل أنتِ متأكدة من اعتماد وحفظ الخطة الدراسية نهائياً؟');">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width: 18px; height: 18px;"><path d="M20 6L9 17l-5-5"/></svg>
                    اعتماد وتأكيد الخطة
                  </button>
                @endif
              </div>

              <!-- عرض أزرار وضع التعديل -->
              <div class="edit-actions">
                <button type="button" class="btn-custom btn-cancel" onclick="disableEditMode()">
                  إلغاء التعديل
                </button>
                <button type="submit" class="btn-custom btn-save-confirm" onclick="return confirm('هل أنتِ متأكدة من حفظ جميع التعديلات؟');">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" style="width: 18px; height: 18px;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                  حفظ وتأكيد التعديلات
                </button>
              </div>
            </div>
          </div>

          <!-- ====== STATS GRID ====== -->
          <div class="plan-stats-grid">
            <div class="plan-stat-box">
              <div class="stat-icon-wrapper" style="background: rgba(47,107,255,0.1); color: #2563EB;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              </div>
              <div>
                <div class="stat-num" id="statYearsCount">{{ count($yearsData) ?: '—' }}</div>
                <div class="stat-label">سنوات الدراسة</div>
              </div>
            </div>

            <div class="plan-stat-box">
              <div class="stat-icon-wrapper" style="background: rgba(139,92,246,0.1); color: #7C3AED;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px;"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
              </div>
              <div>
                <div class="stat-num" id="statSemestersCount">{{ $calcTotalSemesters ?: '—' }}</div>
                <div class="stat-label">عدد الفصول</div>
              </div>
            </div>

            <div class="plan-stat-box">
              <div class="stat-icon-wrapper" style="background: rgba(16,185,129,0.1); color: #059669;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
              </div>
              <div>
                <div class="stat-num" id="statCoursesCount">{{ $calcTotalCourses ?: '—' }}</div>
                <div class="stat-label">إجمالي المساقات</div>
              </div>
            </div>

            <div class="plan-stat-box">
              <div class="stat-icon-wrapper" style="background: rgba(245,158,11,0.1); color: #D97706;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 22px; height: 22px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              </div>
              <div>
                <div class="stat-num" id="statHoursCount">{{ $calcTotalHours ?: '—' }}</div>
                <div class="stat-label">الساعات المعتمدة</div>
              </div>
            </div>
          </div>
        </div>

        <!-- ====== EDIT MODE BANNER ====== -->
        <div class="edit-mode-banner">
          <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 1.2rem;">✏️</span>
            <span><strong>وضع التعديل نشط:</strong> يمكنك الآن تعديل أي مساق (الرمز، الاسم، الساعات، النوع، المتطلب السابق) أو إضافة/حذف مساقات مباشرة.</span>
          </div>
          <button type="submit" class="btn-custom btn-save-confirm" style="padding: 6px 14px; font-size: 0.85rem;">
            حفظ الآن
          </button>
        </div>

        <!-- ====== YEARS & SEMESTERS CONTENT ====== -->
        <div id="planContent">
          @if(!empty($yearsData))
            @foreach($yearsData as $yIdx => $year)
              @php
                $yNum = $year['year_number'] ?? ($yIdx + 1);
              @endphp
              <div class="year-section" data-year-idx="{{ $yIdx }}">
                <input type="hidden" name="years[{{ $yIdx }}][year_number]" value="{{ $yNum }}">

                <div class="year-title">
                  <span style="display: inline-block; width: 10px; height: 10px; background: #2563EB; border-radius: 50%;"></span>
                  <span>السنة الدراسية {{ $yNum }}</span>
                </div>

                @foreach($year['semesters'] ?? [] as $sIdx => $semester)
                  @php
                    $sNum = $semester['semester_number'] ?? ($sIdx + 1);
                  @endphp
                  <div class="semester-card" data-semester-idx="{{ $sIdx }}">
                    <input type="hidden" name="years[{{ $yIdx }}][semesters][{{ $sIdx }}][semester_number]" value="{{ $sNum }}">

                    <div class="semester-header">
                      <div class="semester-title">
                        <span class="sem-badge">الفصل {{ $sNum }}</span>
                        <span>مقررات الفصل الدراسي {{ $sNum }}</span>
                      </div>
                      <span style="font-size: 0.82rem; color: var(--gray-sub); font-weight: 600;" class="semester-courses-count">
                        {{ count($semester['courses'] ?? []) }} مساق
                      </span>
                    </div>

                    <table class="plan-table">
                      <thead>
                        <tr>
                          <th style="width: 140px;">رمز المقرر</th>
                          <th>اسم المقرر</th>
                          <th style="width: 120px; text-align: center;">عدد الساعات</th>
                          <th style="width: 130px;">نوع المقرر</th>
                          <th>المتطلبات السابقة</th>
                          <th class="edit-field" style="width: 50px; text-align: center;">إجراء</th>
                        </tr>
                      </thead>
                      <tbody id="semester-tbody-{{ $yIdx }}-{{ $sIdx }}">
                        @forelse($semester['courses'] ?? [] as $cIdx => $course)
                          @php
                            $hData = $course['credit_hours'] ?? 0;
                            $hours = is_numeric($hData) ? (int)$hData : (int)($hData['total'] ?? 0);
                            $type  = $course['course_type'] ?? 'specialization';
                            $typeAr = match($type) {
                              'college', 'كلية' => 'كلية',
                              'university', 'جامعة' => 'جامعة',
                              default => 'تخصص',
                            };
                            $typeClass = match($typeAr) {
                              'كلية' => 'type-college',
                              'جامعة' => 'type-university',
                              default => 'type-specialization',
                            };
                            $prereqs = $course['prerequisites'] ?? [];
                            if (is_string($prereqs)) {
                              $prereqs = array_filter(array_map('trim', explode(',', $prereqs)));
                            }
                            $prefix = "years[{$yIdx}][semesters][{$sIdx}][courses][{$cIdx}]";
                          @endphp
                          <tr class="course-row">
                            <input type="hidden" name="{{ $prefix }}[year_number]" value="{{ $yNum }}">
                            <input type="hidden" name="{{ $prefix }}[semester_number]" value="{{ $sNum }}">

                            <!-- 1. رمز المقرر -->
                            <td>
                              <span class="view-field course-code-badge">{{ $course['course_code'] ?? '—' }}</span>
                              <div class="edit-field">
                                <input type="text" class="input-form-control code-input" style="font-weight: 800; text-transform: uppercase;"
                                       name="{{ $prefix }}[course_code]" value="{{ $course['course_code'] ?? '' }}" required>
                              </div>
                            </td>

                            <!-- 2. اسم المقرر -->
                            <td>
                              <span class="view-field course-name-text">{{ $course['course_name_ar'] ?? '—' }}</span>
                              <div class="edit-field">
                                <input type="text" class="input-form-control name-input"
                                       name="{{ $prefix }}[course_name_ar]" value="{{ $course['course_name_ar'] ?? '' }}" required>
                              </div>
                            </td>

                            <!-- 3. عدد الساعات -->
                            <td style="text-align: center;">
                              <span class="view-field hours-badge">{{ $hours }} ساعات</span>
                              <div class="edit-field" style="display: inline-block;">
                                <input type="number" class="input-form-control input-hours hours-input"
                                       name="{{ $prefix }}[credit_hours][total]" value="{{ $hours }}" min="0" max="20" onchange="recalculateTotalHours()">
                              </div>
                            </td>

                            <!-- 4. نوع المقرر -->
                            <td>
                              <span class="view-field type-badge {{ $typeClass }}">{{ $typeAr }}</span>
                              <div class="edit-field">
                                <select class="input-form-control type-select" name="{{ $prefix }}[course_type]">
                                  <option value="تخصص" {{ $typeAr == 'تخصص' ? 'selected' : '' }}>تخصص</option>
                                  <option value="كلية" {{ $typeAr == 'كلية' ? 'selected' : '' }}>كلية</option>
                                  <option value="جامعة" {{ $typeAr == 'جامعة' ? 'selected' : '' }}>جامعة</option>
                                </select>
                              </div>
                            </td>

                            <!-- 5. المتطلبات السابقة -->
                            <td>
                              <div class="view-field">
                                @if(!empty($prereqs))
                                  @foreach($prereqs as $pCode)
                                    <span class="prereq-badge">{{ $pCode }}</span>
                                  @endforeach
                                @else
                                  <span style="color: #94A3B8; font-size: 0.82rem;">لا يوجد</span>
                                @endif
                              </div>
                              <div class="edit-field">
                                <input type="text" class="input-form-control prereqs-input"
                                       name="{{ $prefix }}[prerequisites]" value="{{ implode(', ', (array)$prereqs) }}" placeholder="مثال: COMP1301, MATH101">
                              </div>
                            </td>

                            <!-- 6. حذف في وضع التعديل -->
                            <td class="edit-field" style="text-align: center;">
                              <button type="button" class="btn-delete-row" title="حذف هذا المقرر" onclick="removeCourseRow(this)">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                              </button>
                            </td>
                          </tr>
                        @empty
                          <tr class="empty-row">
                            <td colspan="6" style="text-align: center; color: #94A3B8; padding: 24px;">لا توجد مقررات في هذا الفصل.</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>

                    <button type="button" class="add-course-btn" onclick="addCourseRow({{ $yIdx }}, {{ $sIdx }}, {{ $yNum }}, {{ $sNum }})">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width: 16px; height: 16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                      إضافة مقرر جديد لهذا الفصل
                    </button>
                  </div>
                @endforeach
              </div>
            @endforeach
          @else
            <div style="background: white; border-radius: 14px; padding: 40px; text-align: center; color: #64748B; border: 1px solid var(--border-subtle); margin-top: 20px;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="width: 48px; height: 48px; color: #94A3B8; margin-bottom: 12px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              <h3 style="color: var(--navy); font-weight: 700; margin-bottom: 6px;">لا توجد بيانات مقررات في هذه الخطة</h3>
              <p style="font-size: 0.9rem;">يمكنك الضغط على زر التعديل لإضافة المقررات يدوياً، أو إعادة استيراد الملف.</p>
            </div>
          @endif
        </div>

        <!-- ====== FLOATING SAVE BAR ====== -->
        <div class="floating-save-bar">
          <span style="font-size: 0.9rem; font-weight: 600;">لديك تعديلات غير محفوظة على الخطة</span>
          <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-custom btn-cancel" style="background: rgba(255,255,255,0.15); color: white; border: none; padding: 6px 14px;" onclick="disableEditMode()">
              إلغاء
            </button>
            <button type="submit" class="btn-custom btn-save-confirm" style="padding: 6px 18px;" onclick="return confirm('هل أنتِ متأكدة من حفظ جميع التعديلات؟');">
              حفظ التعديلات
            </button>
          </div>
        </div>

      </form>
    </div>
  </main>
</div>

<!-- ======================= SCRIPTS ======================= -->
<script>
  function toggleAiNotice() {
    const content = document.getElementById('aiNoticeContent');
    const chevron = document.getElementById('aiNoticeChevron');
    if (!content) return;
    if (content.style.display === 'none') {
      content.style.display = 'block';
      chevron.style.transform = 'rotate(180deg)';
    } else {
      content.style.display = 'none';
      chevron.style.transform = 'rotate(0deg)';
    }
  }

  function enableEditMode() {
    document.getElementById('planMainContainer').classList.add('edit-mode-active');
  }

  function disableEditMode() {
    if (confirm('هل تريدين إلغاء التعديلات والعودة لوضع العرض؟ (لن يتم حفظ أي تغييرات جديدة)')) {
      location.reload();
    }
  }

  function recalculateTotalHours() {
    let total = 0;
    document.querySelectorAll('.hours-input').forEach(input => {
      total += parseInt(input.value || 0);
    });
    const statHours = document.getElementById('statHoursCount');
    if (statHours) {
      statHours.textContent = total;
    }
  }

  function removeCourseRow(btn) {
    const row = btn.closest('tr');
    if (!row) return;
    if (confirm('هل أنتِ متأكدة من حذف هذا المقرر؟')) {
      row.remove();
      recalculateTotalHours();
      updateCoursesCount();
    }
  }

  function updateCoursesCount() {
    const totalCourses = document.querySelectorAll('.course-row').length;
    const statCourses = document.getElementById('statCoursesCount');
    if (statCourses) {
      statCourses.textContent = totalCourses;
    }
  }

  function addCourseRow(yIdx, sIdx, yNum, sNum) {
    const tbody = document.getElementById(`semester-tbody-${yIdx}-${sIdx}`);
    if (!tbody) return;

    // Remove empty row if present
    const emptyRow = tbody.querySelector('.empty-row');
    if (emptyRow) emptyRow.remove();

    const newIdx = tbody.querySelectorAll('tr.course-row').length;
    const prefix = `years[${yIdx}][semesters][${sIdx}][courses][${newIdx}]`;

    const tr = document.createElement('tr');
    tr.className = 'course-row';
    tr.innerHTML = `
      <input type="hidden" name="${prefix}[year_number]" value="${yNum}">
      <input type="hidden" name="${prefix}[semester_number]" value="${sNum}">

      <td>
        <span class="view-field course-code-badge">—</span>
        <div class="edit-field">
          <input type="text" class="input-form-control code-input" style="font-weight: 800; text-transform: uppercase;"
                 name="${prefix}[course_code]" value="" placeholder="رمز المقرر" required>
        </div>
      </td>

      <td>
        <span class="view-field course-name-text">—</span>
        <div class="edit-field">
          <input type="text" class="input-form-control name-input"
                 name="${prefix}[course_name_ar]" value="" placeholder="اسم المقرر بالعربي" required>
        </div>
      </td>

      <td style="text-align: center;">
        <span class="view-field hours-badge">3 ساعات</span>
        <div class="edit-field" style="display: inline-block;">
          <input type="number" class="input-form-control input-hours hours-input"
                 name="${prefix}[credit_hours][total]" value="3" min="0" max="20" onchange="recalculateTotalHours()">
        </div>
      </td>

      <td>
        <span class="view-field type-badge type-specialization">تخصص</span>
        <div class="edit-field">
          <select class="input-form-control type-select" name="${prefix}[course_type]">
            <option value="تخصص" selected>تخصص</option>
            <option value="كلية">كلية</option>
            <option value="جامعة">جامعة</option>
          </select>
        </div>
      </td>

      <td>
        <div class="view-field">
          <span style="color: #94A3B8; font-size: 0.82rem;">لا يوجد</span>
        </div>
        <div class="edit-field">
          <input type="text" class="input-form-control prereqs-input"
                 name="${prefix}[prerequisites]" value="" placeholder="مثال: COMP1301, MATH101">
        </div>
      </td>

      <td class="edit-field" style="text-align: center;">
        <button type="button" class="btn-delete-row" title="حذف هذا المقرر" onclick="removeCourseRow(this)">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        </button>
      </td>
    `;

    tbody.appendChild(tr);
    recalculateTotalHours();
    updateCoursesCount();

    // Auto-focus code input
    const codeInput = tr.querySelector('.code-input');
    if (codeInput) codeInput.focus();
  }
</script>

<div id="admin-footer-slot"></div>
<script src="{{ asset('js/admin-shell.js') }}"></script>

</body>
</html>
