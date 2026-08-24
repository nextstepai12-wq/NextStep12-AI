@extends('layouts.app')

@section('title', 'إنشاء حساب طالب — NextStep AI')

@section('css')
<link href="{{ asset('Front_end/css/signup.css') }}" rel="stylesheet">
<style>
  .text-danger { color: #e3342f; font-size: 12px; margin-top: 5px; }
  .alert-danger { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; }
</style>
@endsection

@section('content')
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">
      <img src="{{ asset('Front_end/assets/logo.png') }}" alt="NextStep AI" class="brand-logo" style="width:38px;">
      <div class="brand-text">NextStep <span>AI</span></div>
    </div>
    <div class="auth-badge">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
      حساب طالب
    </div>

    <h1 class="auth-title">أنشئ حسابك</h1>
    <p class="auth-subtitle" id="trackGoal">اختر مسارك، واكتشف مسارك الجامعي أو المهني المناسب</p>

    @if(session('error'))
      <div class="alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="signupForm" action="{{ url('/register') }}" method="POST">
      @csrf
      
      <div class="form-group">
        <label>اختر مسارك</label>
        <div class="type-toggle">
          <button type="button" class="type-btn {{ old('student_type', 'new_student') == 'new_student' ? 'active' : '' }}" data-track="new_student">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/><path d="M6 12v5c0 1.5 2.5 3 6 3s6-1.5 6-3v-5"/></svg>
            طالب جديد
          </button>
          <button type="button" class="type-btn {{ old('student_type') == 'university_student' ? 'active' : '' }}" data-track="university_student">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/></svg>
            طالب جامعي
          </button>
        </div>
        <input type="hidden" id="track" name="student_type" value="{{ old('student_type', 'new_student') }}">
      </div>

      <div class="form-group">
        <label for="name">الاسم الكامل</label>
        <div class="input-icon-wrap">
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="أدخل اسمك الكامل" required>
        </div>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
      </div>

      <div class="form-row-2">
        <div class="form-group">
          <label for="email">البريد الإلكتروني</label>
          <div class="input-icon-wrap">
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" required>
          </div>
          @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label for="phone">رقم الهاتف</label>
          <div class="input-icon-wrap">
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="05xxxxxxxx" required>
          </div>
          @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="form-row-2">
        <div class="form-group">
          <label for="password">كلمة المرور</label>
          <div class="input-icon-wrap">
            <input type="password" class="form-control" id="password" name="password" placeholder="كلمة المرور" required>
          </div>
          @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
          <label for="password_confirmation">تأكيد كلمة المرور</label>
          <div class="input-icon-wrap">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="تأكيد كلمة المرور" required>
          </div>
        </div>
      </div>

      <!-- ======================= المسار الأول: طالب جديد ======================= -->
      <div class="conditional-fields" data-show-for="new_student" style="display: {{ old('student_type', 'new_student') == 'new_student' ? 'block' : 'none' }};">
        <div class="form-row-2">
          <div class="form-group">
            <label for="age">العمر</label>
            <div class="input-icon-wrap">
              <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}" placeholder="20" min="14" max="60">
            </div>
            @error('age') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
          <div class="form-group">
            <label for="high_school_score">المعدل</label>
            <div class="input-icon-wrap">
              <input type="number" class="form-control" id="high_school_score" name="high_school_score" value="{{ old('high_school_score') }}" placeholder="95.0" min="50" max="100" step="0.1">
            </div>
            @error('high_school_score') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="high_school_branch_id">الفرع الدراسي</label>
          <select class="form-control" id="high_school_branch_id" name="high_school_branch_id">
            <option value="">-- اختر الفرع --</option>
            @foreach($branches as $branch)
              <option value="{{ $branch->id }}" {{ old('high_school_branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
            @endforeach
          </select>
          @error('high_school_branch_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
      </div>

      <!-- ======================= المسار الثاني: طالب جامعي ======================= -->
      <div class="conditional-fields" data-show-for="university_student" style="display: {{ old('student_type') == 'university_student' ? 'block' : 'none' }};">
        <div class="form-row-2">
          <div class="form-group">
            <label for="university_id">الجامعة الحالية</label>
            <select class="form-control" id="university_id" name="university_id">
              <option value="">-- اختر الجامعة --</option>
              @foreach($universities as $university)
                <option value="{{ $university->id }}" {{ old('university_id') == $university->id ? 'selected' : '' }}>{{ $university->name }}</option>
              @endforeach
            </select>
            @error('university_id') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
          <div class="form-group">
            <label for="major_id">التخصص الحالي</label>
            <select class="form-control" id="major_id" name="major_id">
              <option value="">-- اختر التخصص --</option>
              <!-- Populated via AJAX -->
            </select>
            @error('major_id') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="form-row-2">
          <div class="form-group">
            <label for="academic_level">السنة الدراسية / المستوى</label>
            <select class="form-control" id="academic_level" name="academic_level">
              <option value="">-- اختر المستوى --</option>
              <option value="السنة الأولى" {{ old('academic_level') == 'السنة الأولى' ? 'selected' : '' }}>السنة الأولى</option>
              <option value="السنة الثانية" {{ old('academic_level') == 'السنة الثانية' ? 'selected' : '' }}>السنة الثانية</option>
              <option value="السنة الثالثة" {{ old('academic_level') == 'السنة الثالثة' ? 'selected' : '' }}>السنة الثالثة</option>
              <option value="السنة الرابعة" {{ old('academic_level') == 'السنة الرابعة' ? 'selected' : '' }}>السنة الرابعة</option>
              <option value="السنة الخامسة فأكثر" {{ old('academic_level') == 'السنة الخامسة فأكثر' ? 'selected' : '' }}>السنة الخامسة فأكثر</option>
            </select>
            @error('academic_level') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
          <div class="form-group">
            <label for="gpa">المعدل التراكمي <span class="optional">(اختياري)</span></label>
            <div class="input-icon-wrap">
              <input type="number" class="form-control" id="gpa" name="gpa" value="{{ old('gpa') }}" placeholder="3.2" min="0" max="4" step="0.01">
            </div>
            @error('gpa') <div class="text-danger">{{ $message }}</div> @enderror
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="city">المدينة <span class="optional">(اختياري)</span></label>
        <select class="form-control" id="city" name="city">
          <option value="">-- اختر المدينة --</option>
          <option value="نابلس" {{ old('city') == 'نابلس' ? 'selected' : '' }}>نابلس</option>
          <option value="رام الله" {{ old('city') == 'رام الله' ? 'selected' : '' }}>رام الله</option>
          <option value="الخليل" {{ old('city') == 'الخليل' ? 'selected' : '' }}>الخليل</option>
          <option value="جنين" {{ old('city') == 'جنين' ? 'selected' : '' }}>جنين</option>
          <option value="بيت لحم" {{ old('city') == 'بيت لحم' ? 'selected' : '' }}>بيت لحم</option>
        </select>
        @error('city') <div class="text-danger">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn-submit">
        إنشاء الحساب
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </button>
    </form>

    <p class="auth-footer-text">لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
  </div>
</div>
@endsection

@section('scripts')
<script>
  const trackBtns = document.querySelectorAll('.type-btn');
  const trackInput = document.getElementById('track');
  const trackGoalText = document.getElementById('trackGoal');
  const newStudentFields = document.querySelector('.conditional-fields[data-show-for="new_student"]');
  const universityFields = document.querySelector('.conditional-fields[data-show-for="university_student"]');

  const goals = {
    new_student: 'الهدف: اختيار تخصص وجامعة مناسبة',
    university_student: 'الهدف: تطوير المسار الأكاديمي والمهني أثناء الدراسة'
  };

  function setRequiredWithin(container, isRequired){
    container.querySelectorAll('input, select').forEach(field => {
      if (field.id === 'gpa' || field.id === 'city') return;
      field.required = isRequired;
    });
  }

  // Initialize
  const initialTrack = trackInput.value;
  if(initialTrack === 'new_student') {
      setRequiredWithin(newStudentFields, true);
      setRequiredWithin(universityFields, false);
  } else {
      setRequiredWithin(newStudentFields, false);
      setRequiredWithin(universityFields, true);
  }

  trackBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      trackBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const track = btn.dataset.track;
      trackInput.value = track;
      trackGoalText.textContent = goals[track];

      if (track === 'new_student'){
        newStudentFields.style.display = 'block';
        universityFields.style.display = 'none';
        setRequiredWithin(newStudentFields, true);
        setRequiredWithin(universityFields, false);
      } else {
        newStudentFields.style.display = 'none';
        universityFields.style.display = 'block';
        setRequiredWithin(newStudentFields, false);
        setRequiredWithin(universityFields, true);
      }
    });
  });

  // AJAX For Majors
  document.getElementById('university_id').addEventListener('change', function() {
    const uniId = this.value;
    const majorSelect = document.getElementById('major_id');
    majorSelect.innerHTML = '<option value="">-- جاري التحميل... --</option>';
    
    if(uniId) {
      fetch('/api/lookups/universities/' + uniId + '/majors')
        .then(res => res.json())
        .then(data => {
            majorSelect.innerHTML = '<option value="">-- اختر التخصص --</option>';
            if(data.status === 'success') {
                data.data.forEach(major => {
                    const selected = "{{ old('major_id') }}" == major.id ? "selected" : "";
                    majorSelect.innerHTML += `<option value="${major.id}" ${selected}>${major.title}</option>`;
                });
            }
        })
        .catch(err => {
            majorSelect.innerHTML = '<option value="">-- خطأ في التحميل --</option>';
        });
    } else {
      majorSelect.innerHTML = '<option value="">-- اختر التخصص --</option>';
    }
  });

  // Trigger change on load if old value exists
  if("{{ old('university_id') }}") {
      document.getElementById('university_id').dispatchEvent(new Event('change'));
  }
</script>
@endsection
