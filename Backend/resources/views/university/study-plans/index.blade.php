<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>إدارة الخطط الدراسية — لوحة تحكم الجامعة | NextStep AI</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- ====== CSS ====== -->
  <link rel="stylesheet" href="{{ asset('Front_end/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/admin-shell.css') }}">
  <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/programs.css') }}">
  <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/browsedeanships.css') }}">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <style>
    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 12px;
      border-radius: 60px;
      font-size: 0.78rem;
      font-weight: 700;
    }
    .status-confirmed { background: rgba(22,192,136,0.12); color: var(--green); }
    .status-extracted { background: rgba(47,107,255,0.12); color: var(--blue); }
    .status-processing { background: rgba(53,208,255,0.12); color: #0284c7; }
    .status-pending { background: rgba(180,121,12,0.12); color: var(--gold); }
    .status-failed { background: rgba(198,40,40,0.12); color: var(--red); }

    .action-btn-sm {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: var(--radius-sm);
      font-size: 0.8rem;
      font-weight: 700;
      text-decoration: none;
      transition: var(--transition);
    }
    .btn-primary-sm { background: linear-gradient(135deg, var(--navy), var(--blue)); color: white; }
    .btn-primary-sm:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-secondary-sm { background: var(--gray-bg); color: var(--navy); border: 1px solid rgba(47,107,255,0.1); }
    .btn-secondary-sm:hover { background: #e5e7eb; }
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

    <!-- ====== PAGE HEADER ====== -->
    <div class="admin-page-head">
      <div>
        <h1>إدارة الخطط الدراسية</h1>
        <p>استعرضي الخطط الدراسية المرفوعة، راجعي المقررات المستخرجة بالذكاء الاصطناعي، وقومي باعتماها نهائياً.</p>
      </div>
      <div>
        <a href="{{ route('university.study-plans.create') }}" class="plan-download-btn" style="text-decoration: none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5v14M5 12h14"/></svg>
          رفع خطة دراسية جديدة
        </a>
      </div>
    </div>

    @if(session('status'))
      <div class="empty-plan-hint" style="background: rgba(22,192,136,0.08); border-color: rgba(22,192,136,0.25); color: var(--green); margin-bottom: 20px;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
        {{ session('status') }}
      </div>
    @endif

    <!-- ====== PANEL & TABLE ====== -->
    <div class="admin-panel">
      <div class="chart-card-head" style="margin-bottom: 16px;">
        <h3>سجل الخطط الدراسية</h3>
      </div>

      <div style="overflow-x: auto;">
        <table class="top-programs-table">
          <thead>
            <tr>
              <th>التخصص الأكاديمي</th>
              <th>السنة الأكاديمية</th>
              <th>رقم الإصدار</th>
              <th>حالة الاستخراج</th>
              <th>اسم الملف الأصلي</th>
              <th>تاريخ الرفع</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            @forelse($studyPlans as $plan)
              <tr>
                <td>
                  <strong style="color: var(--navy); font-size: 0.95rem;">{{ $plan->major->title ?? '—' }}</strong>
                </td>
                <td>{{ $plan->academic_year }}</td>
                <td>{{ $plan->version_label ?? '—' }}</td>
                <td>
                  @switch($plan->status)
                    @case('confirmed')
                      <span class="status-badge status-confirmed">✓ مؤكدة ومحفوظة</span>
                      @break
                    @case('extracted')
                      <span class="status-badge status-extracted">🔍 جاهزة للمراجعة</span>
                      @break
                    @case('processing')
                      <span class="status-badge status-processing">⏳ جاري المعالجة...</span>
                      @break
                    @case('pending')
                      <span class="status-badge status-pending">🕒 بانتظار الإرسال</span>
                      @break
                    @case('failed')
                      <span class="status-badge status-failed">✕ فشل الاستخراج</span>
                      @break
                  @endswitch
                </td>
                <td>
                  <span style="font-size: 0.82rem; color: var(--gray);">{{ $plan->source_pdf_original_name }}</span>
                </td>
                <td>
                  <span style="font-size: 0.8rem; color: var(--gray);">{{ $plan->created_at->format('Y-m-d') }}</span>
                </td>
                <td>
                  <div style="display: flex; gap: 8px;">
                    <a href="{{ route('university.study-plans.review', $plan) }}" class="action-btn-sm btn-primary-sm">
                      عرض / مراجعة
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" style="text-align: center; padding: 32px; color: var(--gray);">
                  لا توجد خطط دراسية مرفوعة بعد. اضغطي على <strong>"رفع خطة دراسية جديدة"</strong> للبدء.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top: 20px;">
        {{ $studyPlans->links() }}
      </div>

    </div>

  </main>
</div>

<!-- ======================= SCRIPTS ======================= -->
<div id="admin-footer-slot"></div>
<script src="{{ asset('Front_end/js/admin-shell.js') }}"></script>

</body>
</html>
