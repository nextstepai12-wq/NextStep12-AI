@extends('layouts.app')

@section('title', 'إعدادات الحساب — NextStep AI')

@section('css')
<link href="{{ asset('css/settings.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- ======================= SUB HEADER ======================= -->
<div class="page-subbar">
  <div class="page-subbar-inner">
    <div class="crumb">
      <a href="../index.html">الرئيسية</a>
      <span class="sep">/</span>
      <span class="current">إعدادات الحساب</span>
    </div>
    <a href="../index.html" class="btn-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      الرجوع
    </a>
  </div>
</div>

<!-- ======================= SETTINGS ======================= -->
<div class="settings-wrap">
  <div class="settings-inner">

    <div class="settings-head">
      <div class="settings-eyebrow">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.5-6 8-6s8 2 8 6"/></svg>
        صفحة إعدادات الطالب
      </div>
      <h1>إعدادات الحساب</h1>
      <p>عدّل بياناتك الشخصية وصورة حسابك، وما تنسَ تحفظ التغييرات قبل ما تطلع.</p>
    </div>

    <form class="settings-card" id="settingsForm">

      <!-- Left: form fields -->
      <div class="settings-form-grid">
        <div class="form-group">
          <label for="full_name">الاسم الكامل</label>
          <input type="text" id="full_name" class="form-control" value="سارة أحمد خليل">
        </div>
        <div class="form-group">
          <label for="email">البريد الإلكتروني</label>
          <input type="email" id="email" class="form-control" value="sara.ahmad@email.com">
        </div>

        <div class="form-group">
          <label for="phone">رقم الهاتف</label>
          <input type="tel" id="phone" class="form-control" value="0599123456">
        </div>
        <div class="form-group">
          <label for="gender">الجنس</label>
          <select id="gender" class="form-control">
            <option value="female" selected>أنثى</option>
            <option value="male">ذكر</option>
          </select>
        </div>

        <div class="form-group">
          <label for="birthdate">تاريخ الميلاد</label>
          <input type="date" id="birthdate" class="form-control" value="2006-04-12">
        </div>
        <div class="form-group">
          <label for="nationality">الجنسية</label>
          <input type="text" id="nationality" class="form-control" value="فلسطينية">
        </div>

        <div class="form-group full">
          <label for="city">المدينة</label>
          <select id="city" class="form-control">
            <option value="nablus" selected>نابلس</option>
            <option value="ramallah">رام الله</option>
            <option value="hebron">الخليل</option>
            <option value="jenin">جنين</option>
            <option value="bethlehem">بيت لحم</option>
          </select>
        </div>

        <div class="settings-actions">
          <button type="button" class="btn-cancel">إلغاء</button>
          <button type="submit" class="btn-save" id="saveBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
            حفظ التغييرات
          </button>
        </div>
      </div>

      <!-- Right: avatar -->
      <div class="avatar-col">
        <div class="avatar-frame">
          <img src="{{ asset('assets/5.jpg') }}" alt="صورة الطالب" id="avatarImg">
          <button type="button" class="avatar-edit-btn" id="avatarEditBtn" aria-label="تغيير الصورة">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
          </button>
        </div>
        <button type="button" class="btn-change-photo" id="changePhotoBtn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="6" width="18" height="14" rx="2"/><circle cx="12" cy="13" r="3.5"/><path d="M9 6l1-2h4l1 2"/></svg>
          تغيير الصورة
        </button>
        <p class="avatar-hint">يفضل صورة مربعة بحجم 400×400 بكسل، بصيغة JPG أو PNG.</p>
        <input type="file" id="avatarInput" accept="image/*" hidden>
      </div>

    </form>

  </div>
</div>

<!-- ======================= FOOTER ======================= -->
@endsection
