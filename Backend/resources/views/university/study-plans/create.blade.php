<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>رفع خطة دراسية جديدة — NextStep AI</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- ====== CSS ====== -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardcss/admin-shell.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardcss/programs.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboardcss/browsedeanships.css') }}">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <style>
    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      margin-bottom: 24px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .form-group label {
      font-size: 0.9rem;
      font-weight: 700;
      color: var(--navy);
    }
    .form-control {
      padding: 12px 16px;
      border: 2px solid var(--gray-bg);
      border-radius: var(--radius-sm);
      font-family: inherit;
      font-size: 0.9rem;
      color: var(--gray-dark);
      background: white;
      transition: var(--transition);
      outline: none;
    }
    .form-control:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 4px rgba(47,107,255,0.08);
    }
    .file-upload-zone {
      border: 2px dashed rgba(47,107,255,0.25);
      background: rgba(47,107,255,0.02);
      border-radius: var(--radius);
      padding: 36px 20px;
      text-align: center;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
    }
    .file-upload-zone:hover {
      border-color: var(--blue);
      background: rgba(47,107,255,0.05);
    }
    .file-upload-zone svg {
      width: 48px;
      height: 48px;
      stroke: var(--blue);
      stroke-width: 1.8;
      margin-bottom: 12px;
    }
    .error-alert {
      background: rgba(198,40,40,0.08);
      border: 1px solid rgba(198,40,40,0.2);
      color: var(--red);
      padding: 14px 18px;
      border-radius: var(--radius-sm);
      margin-bottom: 20px;
      font-size: 0.88rem;
    }
    .error-alert ul { margin-right: 20px; margin-top: 6px; }
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
        <h1>رفع خطة دراسية جديدة</h1>
        <p>حددي التخصص والسنة الدراسية وارفعي ملف الـ PDF لاستخراج المواد والساعات آلياً بواسطة الذكاء الاصطناعي.</p>
      </div>
      <div>
        <a href="{{ route('university.study-plans.index') }}" class="plan-action-btn" style="text-decoration: none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          العودة لقائمة الخطط
        </a>
      </div>
    </div>

    @if ($errors->any())
      <div class="error-alert">
        <strong>⚠️ يرجى تصحيح الأخطاء التالية قبل الاستمرار:</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="admin-panel">
      <form action="{{ route('university.study-plans.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf

        <div class="form-grid">
          <!-- التخصص -->
          <div class="form-group">
            <label for="major_id">اختر التخصص الأكاديمي <span style="color:red;">*</span></label>
            <select name="major_id" id="major_id" class="form-control" required>
              <option value="">-- اضغطي لاختيار التخصص --</option>
              @foreach($majors as $major)
                <option value="{{ $major->id }}" {{ old('major_id') == $major->id ? 'selected' : '' }}>
                  {{ $major->title }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- السنة الأكاديمية -->
          <div class="form-group">
            <label for="academic_year">السنة الأكاديمية اعتماد الخطة <span style="color:red;">*</span></label>
            <input type="number" name="academic_year" id="academic_year" class="form-control" 
                   value="{{ old('academic_year', date('Y')) }}" min="2000" max="2100" required>
          </div>
        </div>

        <!-- منطقة رفع الملف -->
        <div class="form-group" style="margin-bottom: 24px;">
          <label>ملف الخطة الدراسية (صيغة PDF فقط - حتى 20 ميجابايت) <span style="color:red;">*</span></label>
          <div class="file-upload-zone" onclick="document.getElementById('pdf_file').click();">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="17 8 12 3 7 8"/>
              <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            <h4 style="color: var(--navy); margin-bottom: 6px; font-weight: 700;">اضغطي هنا لاختيار ملف الخطة الدراسية (PDF)</h4>
            <p style="color: var(--gray); font-size: 0.85rem;" id="fileNameDisplay">أو اسحبي الملف وأسقطيه داخل هذا المربع</p>
            <input type="file" name="file" id="pdf_file" accept=".pdf" style="display: none;" required onchange="updateFileName(this);">
          </div>
        </div>

        <!-- Strict Mode -->
        <div style="margin-bottom: 28px; display: flex; align-items: center; gap: 10px;">
          <input type="checkbox" name="strict" id="strict" value="1" {{ old('strict') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--blue);">
          <label for="strict" style="font-size: 0.88rem; font-weight: 600; color: var(--navy); cursor: pointer;">
            تفعيل التدقيق الصارم (Strict Mode) — إيعاز الذكاء الاصطناعي بمعاملة التنبيهات الصغرى كأخطاء توقفية.
          </label>
        </div>

        <!-- زر الإرسال -->
        <div style="display: flex; justify-content: flex-end;">
          <button type="submit" class="plan-download-btn" id="submitBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            رفع الخطة وبدء الاستخراج بالذكاء الاصطناعي
          </button>
        </div>

      </form>
    </div>

  </main>
</div>

<!-- ======================= SCRIPTS ======================= -->
<script>
  function updateFileName(input) {
    const display = document.getElementById('fileNameDisplay');
    if (input.files && input.files[0]) {
      display.textContent = '📄 الملف المحدد: ' + input.files[0].name + ' (' + (input.files[0].size / 1024 / 1024).toFixed(2) + ' MB)';
      display.style.color = 'var(--blue)';
      display.style.fontWeight = 'bold';
    } else {
      display.textContent = 'أو اسحبي الملف وأسقطيه داخل هذا المربع';
      display.style.color = 'var(--gray)';
    }
  }

  document.getElementById('uploadForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="spinner" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> جاري رفع الملف واستخراج الخطة بالذكاء الاصطناعي...';
  });
</script>

<style>
  @keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<div id="admin-footer-slot"></div>
<script src="{{ asset('js/admin-shell.js') }}"></script>

</body>
</html>
