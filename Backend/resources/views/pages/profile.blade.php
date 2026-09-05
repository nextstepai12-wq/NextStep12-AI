@extends('layouts.app')

@section('title', 'الملف الشخصي — NextStep AI')

@section('css')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ======================= PROFILE ======================= -->
<div class="profile-wrap">
  <div class="profile-inner">

    <div class="profile-layout">

      <!-- Sidebar -->
      <div class="profile-side">
        <div class="side-avatar">لم</div>
        <div class="side-name">لمى محضون</div>
        <div class="side-role">طالبة — علوم الحاسوب</div>

        <nav class="side-menu">
          <a href="results.html">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 3a9 9 0 0 1 9 9"/></svg>
            نسبة التوافق
          </a>
          <a href="study-plan.html">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h6"/></svg>
            الخطة الدراسية
          </a>
          <a href="profile.html" class="active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
            الملف الشخصي
          </a>
          <a href="#">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            الإشعارات
          </a>
          <a href="#">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            الإعدادات
          </a>
          <a href="#">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 12h6M9 16h6M9 8h1"/></svg>
            السيرة الذاتية
          </a>

          <div class="menu-divider"></div>

          <button class="logout-btn" id="btnLogout" type="button">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5M21 12H9"/></svg>
            تسجيل الخروج
          </button>
        </nav>
      </div>

      <!-- Main content -->
      <div class="profile-main">

        <div class="profile-card">
          <div class="profile-card-head">
            <div class="big-avatar">لم</div>
            <div>
              <h2>لمى محضون</h2>
              <p>طالبة مسجّلة على NextStep AI منذ يوليو 2026</p>
            </div>
          </div>

          <div class="info-grid">
            <div class="info-item">
              <div class="info-label">الجامعة</div>
              <div class="info-value">جامعة النجاح الوطنية</div>
            </div>
            <div class="info-item">
              <div class="info-label">السنة الدراسية</div>
              <div class="info-value">السنة الثانية</div>
            </div>
            <div class="info-item">
              <div class="info-label">التخصص</div>
              <div class="info-value">علوم الحاسوب</div>
            </div>
          </div>

          <div class="skills-label">المهارات</div>
          <div class="skills-row">
            <span class="skill-tag">حل المشكلات</span>
            <span class="skill-tag">التفكير المنطقي</span>
            <span class="skill-tag">البرمجة</span>
            <span class="skill-tag">العمل الجماعي</span>
            <span class="skill-tag">إدارة الوقت</span>
          </div>
        </div>

        <div class="quick-stats">
          <div class="qstat-card">
            <div class="qstat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 3a9 9 0 0 1 9 9"/></svg></div>
            <div>
              <div class="qstat-value">94%</div>
              <div class="qstat-label">نسبة التوافق مع التخصص</div>
            </div>
          </div>
          <div class="qstat-card">
            <div class="qstat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h6"/></svg></div>
            <div>
              <div class="qstat-value">45/140</div>
              <div class="qstat-label">ساعة معتمدة مكتملة</div>
            </div>
          </div>
          <div class="qstat-card">
            <div class="qstat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.6.5 1 1.3 1 2.1V17h6v-1.4c0-.8.4-1.6 1-2.1A6 6 0 0 0 12 3z"/></svg></div>
            <div>
              <div class="qstat-value">1</div>
              <div class="qstat-label">اختبار مكتمل</div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<!-- ======================= FOOTER ======================= -->
@endsection
