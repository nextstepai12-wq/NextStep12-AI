<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة برنامج أكاديمي جديد</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('Front_end/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/admin-shell.css') }}">
    <link rel="stylesheet" href="{{ asset('Front_end/css/dashboardcss/add-program.css') }}">
</head>

<body>

<header class="admin-topbar" id="adminTopbar"></header>

<div class="admin-layout">

    <aside class="admin-sidebar" id="adminSidebar"></aside>

    <main class="add-program-page admin-main admin-main-content">

        <div class="admin-breadcrumb">

            <a href="{{ route('university.Majors') }}">
                البرامج الأكاديمية
            </a>

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M15 18l-6-6 6-6"/>
            </svg>

            <span class="current">
                إضافة برنامج جديد
            </span>

        </div>

        <div class="admin-page-head">

            <div>
                <h1>إضافة برنامج أكاديمي جديد</h1>

                <p>
                    اضف تفاصيل البرنامج والخطة الدراسية. هذه البيانات بتُستخدم
                    لعرض التخصص بشكل كامل وربطه بالعمادة والمسار الدراسي.
                </p>
            </div>

        </div>

        <div class="form-layout">

            <aside class="form-stepper">

                <h3>خطوات الإضافة</h3>

                <ul id="stepperList">

                    <li class="stepper-item active" data-target="sectionBasic">
                        <span class="stepper-dot">
                            <span class="dot-inner"></span>
                        </span>

                        <div>
                            <h4>المعلومات الأساسية</h4>
                            <p>الاسم، العمادة، الدرجة</p>
                        </div>
                    </li>

                    <li class="stepper-item" data-target="sectionContent">
                        <span class="stepper-dot">
                            <span class="dot-inner"></span>
                        </span>

                        <div>
                            <h4>المحتوى الوصفي</h4>
                            <p>الأهداف، المؤهلات</p>
                        </div>
                    </li>

                    <li class="stepper-item" data-target="sectionSkills">
                        <span class="stepper-dot">
                            <span class="dot-inner"></span>
                        </span>

                        <div>
                            <h4>المهارات والتعليم</h4>
                            <p>مهارات مفصّلة للطالب</p>
                        </div>
                    </li>

                    <li class="stepper-item" data-target="sectionAi">
                        <span class="stepper-dot">
                            <span class="dot-inner"></span>
                        </span>

                        <div>
                            <h4>التوافق الذكي AI</h4>
                            <p>مهارات مستهدفة، مسارات مهنية</p>
                        </div>
                    </li>

                </ul>

            </aside>

            <form
                class="form-canvas"
                id="programForm"
                method="POST"
                action="{{ route('university.Majors.store') }}"
                enctype="multipart/form-data"
                novalidate
            >

                @csrf

                <section class="admin-panel" id="sectionBasic">

                    <div class="form-section-title">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="12" rx="2"/>
                            <path d="M8 21h8M12 17v4"/>
                        </svg>

                        المعلومات الأساسية

                    </div>

                    <div class="field-group">

                        <label for="progName">
                            اسم التخصص
                        </label>

                        <input
                            type="text"
                            id="progName"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="مثال: علوم الحاسوب"
                            required
                        >

                    </div>

                    <div class="form-row-2">

                        <div class="field-group">

                            <label for="progDegree">
                                الدرجة العلمية
                            </label>

                            <select id="progDegree" name="degree">

                                <option value="">
                                    -- اختر الدرجة --
                                </option>

                                <option value="diploma" {{ old('degree') == 'diploma' ? 'selected' : '' }}>
                                    دبلوم
                                </option>

                                <option value="bachelor" {{ old('degree') == 'bachelor' ? 'selected' : '' }}>
                                    بكالوريوس
                                </option>

                                <option value="master" {{ old('degree') == 'master' ? 'selected' : '' }}>
                                    ماجستير
                                </option>

                                <option value="phd" {{ old('degree') == 'phd' ? 'selected' : '' }}>
                                    دكتوراة
                                </option>

                            </select>

                        </div>

                        <div class="field-group">

                            <label for="progDeanshipSearch">
                                العمادة / الكلية
                            </label>

                            <div class="searchable-select" id="deanshipSearchWrap">

                                <input
                                    type="text"
                                    id="progDeanshipSearch"
                                    class="searchable-select-input"
                                    placeholder="اكتب للبحث عن العمادة أو الكلية..."
                                    autocomplete="off"
                                >

                                <input
                                    type="hidden"
                                    id="progDeanship"
                                    name="deanship_faculty_id"
                                    value="{{ old('deanship_faculty_id') }}"
                                >

                                <button
                                    type="button"
                                    class="searchable-select-clear"
                                    id="deanshipClearBtn"
                                    aria-label="مسح الاختيار"
                                    hidden
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 6L6 18M6 6l12 12"/>
                                    </svg>
                                </button>

                                <ul
                                    class="searchable-select-list"
                                    id="deanshipSearchList"
                                    hidden
                                ></ul>

                            </div>

                        </div>

                    </div>

                    <div class="form-row-2">

                        <div class="field-group">

                            <label for="progDuration">
                                مدة الدراسة بالسنوات
                            </label>

                            <input
                                type="number"
                                id="progDuration"
                                name="duration_years"
                                value="{{ old('duration_years') }}"
                                placeholder="4"
                                min="1"
                                max="8"
                            >

                        </div>

                        <div class="field-group">

                            <label for="totalCreditHours">
                                عدد الساعات المعتمدة
                            </label>

                            <input
                                type="number"
                                id="totalCreditHours"
                                name="total_credit_hours"
                                value="{{ old('total_credit_hours') }}"
                                placeholder="132"
                                min="1"
                            >

                        </div>

                    </div>

                    <div class="form-row-2">

                        <div class="field-group">

                            <label for="minHighSchoolScore">
                                الحد الأدنى لمعدل الثانوية
                            </label>

                            <input
                                type="number"
                                id="minHighSchoolScore"
                                name="min_high_school_score"
                                value="{{ old('min_high_school_score') }}"
                                placeholder="80"
                                min="0"
                                max="100"
                                step="0.01"
                            >

                        </div>

                        <div class="field-group">

                            <label for="creditHourFee">
                                سعر الساعة المعتمدة
                            </label>

                            <input
                                type="number"
                                id="creditHourFee"
                                name="credit_hour_fee"
                                value="{{ old('credit_hour_fee') }}"
                                placeholder="25"
                                min="0"
                                step="0.01"
                            >

                        </div>

                    </div>

                    <div class="form-row-2">

                        <div class="field-group">

                            <label for="progScholarship">
                                نسبة المنحة على التخصص
                                <span class="optional">(اختياري)</span>
                            </label>

                            <div class="input-suffix-wrap">

                                <input
                                    type="number"
                                    id="progScholarship"
                                    name="scholarship_percentage"
                                    value="{{ old('scholarship_percentage') }}"
                                    placeholder="0"
                                    min="0"
                                    max="100"
                                    step="1"
                                >

                                <span class="input-suffix">
                                    %
                                </span>

                            </div>

                            <p class="field-hint">
                                اتركه فارغ إذا لا تتوفر منحة.
                            </p>

                        </div>

                        <div class="field-group">

                            <label for="progScholarshipNote">
                                ملاحظات المنحة
                                <span class="optional">(اختياري)</span>
                            </label>

                            <input
                                type="text"
                                id="progScholarshipNote"
                                name="scholarship_note"
                                value="{{ old('scholarship_note') }}"
                                placeholder="مثال: منحة كاملة لذوي الاحتياجات الخاصة"
                            >

                        </div>

                    </div>

                    <div class="field-group">

                        <label for="studyPlanFile">
                            الخطة الدراسية
                            <span class="optional">(اختياري للمسودة)</span>
                        </label>

                        <div class="study-plan-upload" id="studyPlanUpload">

                            <input
                                type="file"
                                id="studyPlanFile"
                                name="study_plan_file_url"
                                accept=".pdf,.xlsx,.xls,.csv"
                                hidden
                            >

                            <label for="studyPlanFile" class="study-plan-dropzone">

                                <span class="study-plan-icon">

                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <path d="M14 2v6h6"/>
                                        <path d="M12 18v-6"/>
                                        <path d="M9 15l3-3 3 3"/>
                                    </svg>

                                </span>

                                <span class="study-plan-text">

                                    <strong>
                                        إضافة الخطة الدراسية
                                    </strong>

                                    <small>
                                        PDF أو Excel أو CSV — الحد الأقصى 20MB
                                    </small>

                                </span>

                            </label>

                            <div class="study-plan-file" id="studyPlanFileRow" hidden>

                                <div class="study-plan-file-info">

                                    <span class="study-plan-file-icon">

                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <path d="M14 2v6h6"/>
                                        </svg>

                                    </span>

                                    <div>

                                        <strong id="studyPlanFileName">—</strong>

                                        <small id="studyPlanFileSize">—</small>

                                    </div>

                                </div>

                                <button
                                    type="button"
                                    class="study-plan-remove"
                                    id="removeStudyPlan"
                                    aria-label="حذف الخطة الدراسية"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 6L6 18M6 6l12 12"/>
                                    </svg>
                                </button>

                            </div>

                        </div>

                        <p class="field-hint">
                            ارفع الخطة الدراسية الخاصة بهذا التخصص حتى يتمكن النظام
                            من قراءتها وربط المواد والمقررات بالتخصص.
                        </p>

                    </div>

                </section>

                <section class="admin-panel" id="sectionContent">

                    <div class="form-section-title">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <path d="M14 2v6h6M9 13h6M9 17h6"/>
                        </svg>

                        المحتوى الوصفي

                    </div>

                    <div class="field-group">

                        <label for="progGoals">
                            أهداف التخصص
                        </label>

                        <textarea
                            id="progGoals"
                            name="description"
                            placeholder="إعداد كوادر قادرة على..."
                        >{{ old('description') }}</textarea>

                    </div>

                    <div class="field-group">

                        <label for="progQualifications">
                            مؤهلات يجب أن يمتلكها الطالب
                        </label>

                        <textarea
                            id="progQualifications"
                            name="qualifications"
                            placeholder="تفكير منطقي وحل مشكلات، ..."
                        >{{ old('qualifications') }}</textarea>

                    </div>

                    <div class="field-group">

                        <label for="careerOpportunities">
                            الفرص والمجالات الوظيفية
                        </label>

                        <textarea
                            id="careerOpportunities"
                            name="career_opportunities"
                            placeholder="مهندس برمجيات، محلل بيانات، مطور تطبيقات..."
                        >{{ old('career_opportunities') }}</textarea>

                    </div>

                    <div class="field-group">

                        <label for="coverImage">
                            صورة غلاف التخصص
                            <span class="optional">(اختياري)</span>
                        </label>

                        <input
                            type="file"
                            id="coverImage"
                            name="cover_image"
                            accept="image/*"
                        >

                    </div>

                    <div class="field-group">

                        <label for="videoUrl">
                            رابط الفيديو التعريفي
                            <span class="optional">(اختياري)</span>
                        </label>

                        <input
                            type="url"
                            id="videoUrl"
                            name="video_url"
                            value="{{ old('video_url') }}"
                            placeholder="https://youtube.com/..."
                        >

                    </div>

                </section>

                <section class="admin-panel" id="sectionSkills">

                    <div class="form-section-title">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 18l6-6-6-6M8 6l-6 6 6 6"/>
                        </svg>

                        المهارات والتعليم الأساسي

                    </div>

                    <p class="field-hint skills-intro">
                        هذه المهارات بتظهر كبطاقات مفصّلة بصفحة التخصص للطالب.
                    </p>

                    <div class="skills-repeater" id="skillsRepeater"></div>

                    <button type="button" class="add-skill-btn" id="addSkillBtn">

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>

                        إضافة مهارة

                    </button>

                </section>

                <section class="ai-panel" id="sectionAi">

                    <div class="ai-panel-head">

                        <div class="title-group">

                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2a5 5 0 0 0-5 5c0 2 1 3 1 5v2h8v-2c0-2 1-3 1-5a5 5 0 0 0-5-5z"/>
                                <path d="M9 21h6M10 18h4"/>
                            </svg>

                            <h3>
                                التوافق الذكي (AI Matching)
                            </h3>

                        </div>

                        <span class="ai-panel-badge">
                            مُعزز بالذكاء الاصطناعي
                        </span>

                    </div>

                    <p class="ai-panel-hint">
                        هذه البيانات بتُستخدم لمطابقة الطلاب الأنسب لهذا البرنامج.
                        كن دقيقة قدر الإمكان.
                    </p>

                    <div class="ai-panel-grid">

                        <div class="ai-tag-box">

                            <label>

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="9"/>
                                    <circle cx="12" cy="12" r="4"/>
                                    <circle cx="12" cy="12" r="0.5" fill="currentColor"/>
                                </svg>

                                المهارات المستهدفة

                            </label>

                            <p class="tag-desc">
                                المهارات التي يطوّرها البرنامج بالطالب.
                            </p>

                            <div class="tag-chips" id="skillTags"></div>

                            <div class="tag-input-row">

                                <input
                                    type="text"
                                    id="skillTagInput"
                                    placeholder="مثال: التفكير التحليلي"
                                >

                                <button
                                    type="button"
                                    class="tag-add-btn"
                                    data-target="skillTags"
                                    data-input="skillTagInput"
                                >
                                    إضافة
                                </button>

                            </div>

                        </div>

                        <div class="ai-tag-box">

                            <label>

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 7h-3V5a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a1 1 0 0 0-1-1z"/>
                                </svg>

                                المسارات المهنية (سوق العمل)

                            </label>

                            <p class="tag-desc">
                                الوظائف المتوقعة لخريجي هذا البرنامج.
                            </p>

                            <div class="tag-chips" id="careerTags"></div>

                            <div class="tag-input-row">

                                <input
                                    type="text"
                                    id="careerTagInput"
                                    placeholder="مثال: مهندس بيانات"
                                >

                                <button
                                    type="button"
                                    class="tag-add-btn"
                                    data-target="careerTags"
                                    data-input="careerTagInput"
                                >
                                    إضافة
                                </button>

                            </div>

                        </div>

                    </div>

                </section>

                <div class="form-actions">

                    <button type="submit" class="btn-save-primary" id="saveBtn">

                        نشر البرنامج

                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M5 12h14M13 5l7 7-7 7"/>
                        </svg>

                    </button>

                    <button type="button" class="btn-cancel-outline" id="draftBtn">
                        حفظ كمسودة
                    </button>

                    <button
                        type="button"
                        class="btn-cancel-outline"
                        onclick="window.location.href='{{ route('university.Majors') }}'"
                    >
                        إلغاء
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

<div class="app-modal-overlay" id="appModalOverlay">

    <div class="app-modal" role="dialog" aria-modal="true">

        <div class="app-modal-icon" id="appModalIcon"></div>

        <h3 id="appModalTitle"></h3>

        <p id="appModalMsg"></p>

        <div class="app-modal-actions" id="appModalActions"></div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', () => {

    const programForm = document.getElementById('programForm');
    const saveBtn = document.getElementById('saveBtn');
    const draftBtn = document.getElementById('draftBtn');
    const skillsRepeater = document.getElementById('skillsRepeater');
    const addSkillBtn = document.getElementById('addSkillBtn');

    const appModalOverlay = document.getElementById('appModalOverlay');
    const appModalIcon = document.getElementById('appModalIcon');
    const appModalTitle = document.getElementById('appModalTitle');
    const appModalMsg = document.getElementById('appModalMsg');
    const appModalActions = document.getElementById('appModalActions');

    const deanshipSearchInput = document.getElementById('progDeanshipSearch');
    const deanshipHiddenInput = document.getElementById('progDeanship');
    const deanshipList = document.getElementById('deanshipSearchList');
    const deanshipClearBtn = document.getElementById('deanshipClearBtn');

    const deanshipsCache = @json($deanshipFaculties ?? []);

    function openModal({
        type = 'success',
        title,
        message,
        confirmText = 'تمام',
        cancelText = 'إلغاء',
        onConfirm = null
    }) {

        appModalIcon.className = `app-modal-icon ${type}`;

        appModalIcon.textContent =
            type === 'success'
                ? '✓'
                : type === 'error'
                    ? '!'
                    : '?';

        appModalTitle.textContent = title;
        appModalMsg.textContent = message;
        appModalActions.innerHTML = '';

        if (onConfirm) {

            const cancelBtn = document.createElement('button');

            cancelBtn.type = 'button';
            cancelBtn.className = 'app-modal-btn-outline';
            cancelBtn.textContent = cancelText;
            cancelBtn.addEventListener('click', closeModal);

            const confirmBtn = document.createElement('button');

            confirmBtn.type = 'button';
            confirmBtn.className = `app-modal-btn-primary ${type === 'error' ? 'danger' : ''}`;
            confirmBtn.textContent = confirmText;

            confirmBtn.addEventListener('click', () => {
                closeModal();
                onConfirm();
            });

            appModalActions.appendChild(cancelBtn);
            appModalActions.appendChild(confirmBtn);

        } else {

            const okBtn = document.createElement('button');

            okBtn.type = 'button';
            okBtn.className = 'app-modal-btn-primary';
            okBtn.textContent = confirmText;
            okBtn.addEventListener('click', closeModal);

            appModalActions.appendChild(okBtn);
        }

        appModalOverlay.classList.add('is-open');
    }

    function closeModal() {
        appModalOverlay.classList.remove('is-open');
    }

    appModalOverlay.addEventListener('click', e => {

        if (e.target === appModalOverlay) {
            closeModal();
        }

    });

    document.addEventListener('keydown', e => {

        if (
            e.key === 'Escape' &&
            appModalOverlay.classList.contains('is-open')
        ) {
            closeModal();
        }

    });

    document.querySelectorAll('.stepper-item').forEach(item => {

        item.addEventListener('click', () => {

            const target = document.getElementById(item.dataset.target);

            if (!target) return;

            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        });

    });

    const sections = [
        document.getElementById('sectionBasic'),
        document.getElementById('sectionContent'),
        document.getElementById('sectionSkills'),
        document.getElementById('sectionAi')
    ];

    const stepperItems = document.querySelectorAll('.stepper-item');

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if (!entry.isIntersecting) return;

            stepperItems.forEach(item => {

                item.classList.toggle(
                    'active',
                    item.dataset.target === entry.target.id
                );

            });

        });

    }, {
        threshold: 0.25
    });

    sections.forEach(section => {

        if (section) {
            observer.observe(section);
        }

    });

    function addSkillRow() {

        const row = document.createElement('div');

        row.className = 'skill-row';

        row.innerHTML = `
            <div class="skill-row-fields">

                <div class="field-group">

                    <label>
                        اسم المهارة
                    </label>

                    <input
                        type="text"
                        class="skill-title"
                        placeholder="مثال: البرمجة"
                    >

                </div>

                <div class="field-group">

                    <label>
                        وصف المهارة
                    </label>

                    <input
                        type="text"
                        class="skill-desc"
                        placeholder="وصف مختصر للمهارة"
                    >

                </div>

            </div>

            <button
                type="button"
                class="skill-row-remove"
                aria-label="حذف المهارة"
            >

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>

            </button>
        `;

        row.querySelector('.skill-row-remove').addEventListener(
            'click',
            () => row.remove()
        );

        skillsRepeater.appendChild(row);
    }

    addSkillBtn.addEventListener('click', addSkillRow);

    addSkillRow();

    function addTag(containerId, value) {

        const val = value.trim();

        if (!val) return;

        const container = document.getElementById(containerId);

        const chip = document.createElement('span');

        chip.className = 'tag-chip';

        const text = document.createElement('span');

        text.textContent = val;

        const button = document.createElement('button');

        button.type = 'button';
        button.setAttribute('aria-label', 'حذف');

        button.innerHTML = `
            <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2.5"
            >
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        `;

        button.addEventListener('click', () => chip.remove());

        chip.appendChild(text);
        chip.appendChild(button);

        container.appendChild(chip);
    }

    document.querySelectorAll('.tag-add-btn').forEach(btn => {

        btn.addEventListener('click', () => {

            const input = document.getElementById(btn.dataset.input);

            addTag(btn.dataset.target, input.value);

            input.value = '';
            input.focus();

        });

    });

    ['skillTagInput', 'careerTagInput'].forEach(inputId => {

        const input = document.getElementById(inputId);

        input.addEventListener('keydown', e => {

            if (e.key !== 'Enter') return;

            e.preventDefault();

            const targetId =
                inputId === 'skillTagInput'
                    ? 'skillTags'
                    : 'careerTags';

            addTag(targetId, input.value);

            input.value = '';
        });

    });

    function collectTags(containerId) {

        return Array.from(
            document
                .getElementById(containerId)
                .querySelectorAll('.tag-chip')
        ).map(chip =>
            chip.querySelector('span').textContent.trim()
        );

    }

    function renderDeanshipList(filterText = '') {

        const q = filterText.trim().toLowerCase();

        const filtered = q
            ? deanshipsCache.filter(d =>
                d.name.toLowerCase().includes(q)
            )
            : deanshipsCache;

        deanshipList.innerHTML = '';

        if (!filtered.length) {

            const li = document.createElement('li');

            li.className = 'empty';
            li.textContent = 'لا توجد نتائج مطابقة';

            deanshipList.appendChild(li);

            deanshipList.hidden = false;

            return;
        }

        filtered.forEach(d => {

            const li = document.createElement('li');

            li.textContent = d.name;
            li.dataset.id = d.id;

            li.addEventListener('click', () => {

                deanshipHiddenInput.value = d.id;
                deanshipSearchInput.value = d.name;
                deanshipList.hidden = true;
                deanshipClearBtn.hidden = false;

            });

            deanshipList.appendChild(li);

        });

        deanshipList.hidden = false;
    }

    deanshipSearchInput.addEventListener('focus', () => {

        renderDeanshipList(
            deanshipSearchInput.value
        );

    });

    deanshipSearchInput.addEventListener('input', () => {

        deanshipHiddenInput.value = '';

        deanshipClearBtn.hidden =
            !deanshipSearchInput.value;

        renderDeanshipList(
            deanshipSearchInput.value
        );

    });

    deanshipClearBtn.addEventListener('click', () => {

        deanshipSearchInput.value = '';
        deanshipHiddenInput.value = '';
        deanshipClearBtn.hidden = true;

        deanshipSearchInput.focus();

        renderDeanshipList('');
    });

    document.addEventListener('click', e => {

        const wrap = document.getElementById('deanshipSearchWrap');

        if (wrap && !wrap.contains(e.target)) {
            deanshipList.hidden = true;
        }

    });

    const studyPlanFile = document.getElementById('studyPlanFile');
    const studyPlanFileRow = document.getElementById('studyPlanFileRow');
    const studyPlanFileName = document.getElementById('studyPlanFileName');
    const studyPlanFileSize = document.getElementById('studyPlanFileSize');
    const removeStudyPlan = document.getElementById('removeStudyPlan');

    const MAX_FILE_SIZE = 20 * 1024 * 1024;

    const allowedExtensions = [
        'pdf',
        'xlsx',
        'xls',
        'csv'
    ];

    function formatFileSize(bytes) {

        if (bytes < 1024) {
            return `${bytes} B`;
        }

        if (bytes < 1024 * 1024) {
            return `${(bytes / 1024).toFixed(1)} KB`;
        }

        return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    function clearStudyPlan() {

        studyPlanFile.value = '';
        studyPlanFileRow.hidden = true;

    }

    studyPlanFile.addEventListener('change', () => {

        const file = studyPlanFile.files[0];

        if (!file) return;

        const extension = file.name
            .split('.')
            .pop()
            .toLowerCase();

        if (!allowedExtensions.includes(extension)) {

            clearStudyPlan();

            openModal({
                type: 'error',
                title: 'نوع الملف غير مدعوم',
                message: 'الخطة الدراسية يجب أن تكون PDF أو Excel أو CSV.'
            });

            return;
        }

        if (file.size > MAX_FILE_SIZE) {

            clearStudyPlan();

            openModal({
                type: 'error',
                title: 'الملف كبير جداً',
                message: 'الحد الأقصى لحجم الخطة الدراسية هو 20 ميجابايت.'
            });

            return;
        }

        studyPlanFileName.textContent = file.name;
        studyPlanFileSize.textContent = formatFileSize(file.size);
        studyPlanFileRow.hidden = false;

    });

    removeStudyPlan.addEventListener(
        'click',
        clearStudyPlan
    );

    function validateForm() {

        const requiredFields = [
            document.getElementById('progName'),
            document.getElementById('progDuration'),
            document.getElementById('totalCreditHours'),
            document.getElementById('minHighSchoolScore'),
            document.getElementById('creditHourFee')
        ];

        for (const field of requiredFields) {

            if (!field.value.trim()) {

                openModal({
                    type: 'error',
                    title: 'بيانات غير كاملة',
                    message: 'تأكد من تعبئة جميع الحقول المطلوبة.'
                });

                field.focus();

                return false;
            }

        }

        if (!deanshipHiddenInput.value) {

            openModal({
                type: 'error',
                title: 'لم يتم اختيار العمادة',
                message: 'لازم تختار العمادة أو الكلية من القائمة.'
            });

            deanshipSearchInput.focus();

            return false;
        }

        const score = Number(
            document.getElementById('minHighSchoolScore').value
        );

        if (score < 0 || score > 100) {

            openModal({
                type: 'error',
                title: 'المعدل غير صحيح',
                message: 'الحد الأدنى لمعدل الثانوية يجب أن يكون بين 0 و100.'
            });

            return false;
        }

        const scholarship =
            document.getElementById('progScholarship').value;

        if (
            scholarship !== '' &&
            (
                scholarship < 0 ||
                scholarship > 100
            )
        ) {

            openModal({
                type: 'error',
                title: 'نسبة منحة غير صحيحة',
                message: 'نسبة المنحة يجب أن تكون بين 0 و100.'
            });

            return false;
        }

        return true;
    }

    function appendDynamicFields() {

        document
            .querySelectorAll(
                'input[name="skills[]"], input[name="target_skills[]"], input[name="career_paths[]"]'
            )
            .forEach(input => input.remove());

        Array.from(
            skillsRepeater.querySelectorAll('.skill-row')
        ).forEach(row => {

            const title =
                row.querySelector('.skill-title').value.trim();

            const description =
                row.querySelector('.skill-desc').value.trim();

            if (!title) return;

            const titleInput =
                document.createElement('input');

            titleInput.type = 'hidden';
            titleInput.name = 'skills[]';
            titleInput.value =
                JSON.stringify({
                    title: title,
                    description: description
                });

            programForm.appendChild(titleInput);

        });

        collectTags('skillTags').forEach(tag => {

            const input =
                document.createElement('input');

            input.type = 'hidden';
            input.name = 'target_skills[]';
            input.value = tag;

            programForm.appendChild(input);

        });

        collectTags('careerTags').forEach(tag => {

            const input =
                document.createElement('input');

            input.type = 'hidden';
            input.name = 'career_paths[]';
            input.value = tag;

            programForm.appendChild(input);

        });
    }

    function submitProgram(status, triggerBtn) {

        if (!validateForm()) {
            return;
        }

        appendDynamicFields();

        let statusInput =
            document.getElementById('programStatus');

        if (!statusInput) {

            statusInput =
                document.createElement('input');

            statusInput.type = 'hidden';
            statusInput.id = 'programStatus';
            statusInput.name = 'status';

            programForm.appendChild(statusInput);
        }

        statusInput.value = status;

        triggerBtn.disabled = true;

        const originalContent = triggerBtn.innerHTML;

        triggerBtn.textContent =
            status === 'draft'
                ? 'جارٍ الحفظ...'
                : 'جارٍ النشر...';

        programForm.submit();

    }

    programForm.addEventListener('submit', e => {

        e.preventDefault();

        submitProgram(
            'published',
            saveBtn
        );

    });

    draftBtn.addEventListener('click', () => {

        submitProgram(
            'draft',
            draftBtn
        );

    });

    @if(session('success'))

        openModal({
            type: 'success',
            title: 'تم بنجاح',
            message: @json(session('success'))
        });

    @endif

    @if($errors->any())

        openModal({
            type: 'error',
            title: 'حدث خطأ',
            message: @json($errors->first())
        });

    @endif

});

</script>

<div id="admin-footer-slot"></div>

<script src="{{ asset('Front_end/js/admin-shell.js') }}"></script>

</body>
</html>
