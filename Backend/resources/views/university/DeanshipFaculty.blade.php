<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة كلية / عمادة جديدة</title>

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

        <!-- Breadcrumb -->

        <div class="admin-breadcrumb">

            {{-- <a href="{{ route('university.DeanshipFaculty.index') }}">
                الكليات والعمادات
            </a> --}}

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M15 18l-6-6 6-6"/>
            </svg>

            <span class="current">
                إضافة جديدة
            </span>

        </div>


        <!-- Page Header -->

        <div class="admin-page-head">

            <div>

                <h1>إضافة كلية / عمادة جديدة</h1>

                <p>
                    أضف بيانات الكلية أو العمادة التابعة لجامعتك، وسيتم استخدامها
                    لعرض البيانات الأكاديمية للطلاب وربط التخصصات بها.
                </p>

            </div>

        </div>


        <!-- Main Layout -->

        <div class="form-layout">


            <!-- Stepper -->

            <aside class="form-stepper">

                <h3>خطوات الإضافة</h3>

                <ul id="stepperList">

                    <li
                        class="stepper-item active"
                        data-target="sectionBasic"
                    >

                        <span class="stepper-dot">
                            <span class="dot-inner"></span>
                        </span>

                        <div>

                            <h4>المعلومات الأساسية</h4>

                            <p>
                                الاسم والنوع واسم العميد
                            </p>

                        </div>

                    </li>


                    <li
                        class="stepper-item"
                        data-target="sectionContact"
                    >

                        <span class="stepper-dot">
                            <span class="dot-inner"></span>
                        </span>

                        <div>

                            <h4>التواصل والوصف</h4>

                            <p>
                                البريد والوصف
                            </p>

                        </div>

                    </li>


                    <li
                        class="stepper-item"
                        data-target="sectionImage"
                    >

                        <span class="stepper-dot">
                            <span class="dot-inner"></span>
                        </span>

                        <div>

                            <h4>صورة الغلاف</h4>

                            <p>
                                صورة الكلية أو العمادة
                            </p>

                        </div>

                    </li>

                </ul>

            </aside>


            <!-- Form -->

            <form
                class="form-canvas"
                id="deanshipForm"
                method="POST"
                action="{{ route('university.DeanshipFaculty.store') }}"
                enctype="multipart/form-data"
            >

                @csrf


                <!-- =====================================================
                     BASIC
                ====================================================== -->

                <section
                    class="admin-panel"
                    id="sectionBasic"
                >

                    <div class="form-section-title">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <rect x="3" y="4" width="18" height="12" rx="2"/>
                            <path d="M8 21h8M12 17v4"/>
                        </svg>

                        المعلومات الأساسية

                    </div>


                    <!-- Name -->

                    <div class="field-group">

                        <label for="name">
                            اسم الكلية / العمادة
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="مثال: كلية الهندسة وتكنولوجيا المعلومات"
                            required
                        >

                        @error('name')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <!-- Type -->

                    <div class="form-row-2">

                        <div class="field-group">

                            <label for="type">
                                النوع
                            </label>

                            <select
                                id="type"
                                name="type"
                                required
                            >

                                <option value="">
                                    اختر النوع
                                </option>

                                <option
                                    value="faculty"
                                    {{ old('type') === 'faculty' ? 'selected' : '' }}
                                >
                                    كلية
                                </option>

                                <option
                                    value="deanship"
                                    {{ old('type') === 'deanship' ? 'selected' : '' }}
                                >
                                    عمادة
                                </option>

                            </select>

                            @error('type')
                                <small class="field-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        <!-- Dean Name -->

                        <div class="field-group">

                            <label for="dean_name">
                                اسم العميد / المسؤول
                            </label>

                            <input
                                type="text"
                                id="dean_name"
                                name="dean_name"
                                value="{{ old('dean_name') }}"
                                placeholder="مثال: د. أحمد العلي"
                                required
                            >

                            @error('dean_name')
                                <small class="field-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>

                    </div>

                </section>


                <!-- =====================================================
                     CONTACT
                ====================================================== -->

                <section
                    class="admin-panel"
                    id="sectionContact"
                >

                    <div class="form-section-title">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <path d="M14 2v6h6M9 13h6M9 17h6"/>
                        </svg>

                        التواصل والوصف

                    </div>


                    <!-- Email -->

                    <div class="field-group">

                        <label for="email">
                            البريد الإلكتروني
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="engineering@university.edu"
                            required
                        >

                        @error('email')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <!-- Description -->

                    <div class="field-group">

                        <label for="description">
                            نبذة عن الكلية / العمادة
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="اكتب نبذة مختصرة عن الكلية أو العمادة وتخصصاتها ورؤيتها..."
                            required
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </section>


                <!-- =====================================================
                     COVER IMAGE
                ====================================================== -->

                <section
                    class="admin-panel"
                    id="sectionImage"
                >

                    <div class="form-section-title">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>

                        صورة الغلاف

                    </div>


                    <div class="field-group">

                        <label for="cover_image">
                            صورة غلاف الكلية / العمادة
                            <span class="optional">
                                (اختياري)
                            </span>
                        </label>


                        <div
                            class="study-plan-upload"
                            id="coverImageUpload"
                        >

                            <input
                                type="file"
                                id="cover_image"
                                name="cover_image"
                                accept=".png,.jpg,.jpeg,.webp"
                                hidden
                            >


                            <label
                                for="cover_image"
                                class="study-plan-dropzone"
                            >

                                <span class="study-plan-icon">

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <path d="M14 2v6h6"/>
                                        <path d="M12 18v-6"/>
                                        <path d="M9 15l3-3 3 3"/>
                                    </svg>

                                </span>


                                <span class="study-plan-text">

                                    <strong>
                                        إضافة صورة الغلاف
                                    </strong>

                                    <small>
                                        PNG أو JPG أو WEBP — الحد الأقصى 5MB
                                    </small>

                                </span>

                            </label>


                            <!-- Selected File -->

                            <div
                                class="study-plan-file"
                                id="coverImageFileRow"
                                hidden
                            >

                                <div class="study-plan-file-info">

                                    <span class="study-plan-file-icon">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <path d="M14 2v6h6"/>
                                        </svg>

                                    </span>

                                    <div>

                                        <strong id="coverImageFileName">
                                            —
                                        </strong>

                                        <small id="coverImageFileSize">
                                            —
                                        </small>

                                    </div>

                                </div>


                                <button
                                    type="button"
                                    class="study-plan-remove"
                                    id="removeCoverImage"
                                    aria-label="حذف الصورة"
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

                            </div>

                        </div>


                        <p class="field-hint">
                            صورة الغلاف ستظهر في صفحة الكلية أو العمادة وصفحة تفاصيلها.
                        </p>

                        @error('cover_image')
                            <small class="field-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </section>


                <!-- =====================================================
                     ACTIONS
                ====================================================== -->

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn-save-primary"
                        id="saveBtn"
                    >

                        إضافة الكلية / العمادة

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                        >
                            <path d="M5 12h14M13 5l7 7-7 7"/>
                        </svg>

                    </button>

{{-- 
                    <a
                        href="{{ route('university.DeanshipFaculty.index') }}"
                        class="btn-cancel-outline">
                        إلغاء
                    </a> --}}

                </div>

            </form>

        </div>

    </main>

</div>


<!-- Footer -->

<div id="admin-footer-slot"></div>


<script src="{{ asset('Front_end/js/admin-shell.js') }}"></script>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', () => {

    /* =========================================================
       STEPPER
    ========================================================= */

    document
        .querySelectorAll('.stepper-item')
        .forEach(item => {

            item.addEventListener('click', () => {

                const target =
                    document.getElementById(
                        item.dataset.target
                    );

                if (!target) {
                    return;
                }

                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            });

        });


    const sections = [
        document.getElementById('sectionBasic'),
        document.getElementById('sectionContact'),
        document.getElementById('sectionImage')
    ];


    const stepperItems =
        document.querySelectorAll('.stepper-item');


    const observer =
        new IntersectionObserver(
            entries => {

                entries.forEach(entry => {

                    if (!entry.isIntersecting) {
                        return;
                    }

                    const id =
                        entry.target.id;

                    stepperItems.forEach(item => {

                        item.classList.toggle(
                            'active',
                            item.dataset.target === id
                        );

                    });

                });

            },
            {
                threshold: 0.25
            }
        );


    sections.forEach(section => {

        if (section) {
            observer.observe(section);
        }

    });


    /* =========================================================
       COVER IMAGE
    ========================================================= */

    const coverImage =
        document.getElementById('cover_image');

    const coverImageFileRow =
        document.getElementById('coverImageFileRow');

    const coverImageFileName =
        document.getElementById('coverImageFileName');

    const coverImageFileSize =
        document.getElementById('coverImageFileSize');

    const removeCoverImage =
        document.getElementById('removeCoverImage');


    const MAX_FILE_SIZE =
        5 * 1024 * 1024;


    const allowedExtensions = [
        'png',
        'jpg',
        'jpeg',
        'webp'
    ];


    function formatFileSize(bytes) {

        if (bytes < 1024) {
            return `${bytes} B`;
        }

        if (bytes < 1024 * 1024) {
            return `${(bytes / 1024).toFixed(1)} KB`;
        }

        return `${(
            bytes /
            (1024 * 1024)
        ).toFixed(1)} MB`;

    }


    function clearCoverImage() {

        coverImage.value = '';

        coverImageFileRow.hidden = true;

        coverImageFileName.textContent = '—';

        coverImageFileSize.textContent = '—';

    }


    coverImage.addEventListener('change', () => {

        const file =
            coverImage.files[0];

        if (!file) {
            return;
        }


        const extension =
            file.name
                .split('.')
                .pop()
                .toLowerCase();


        if (!allowedExtensions.includes(extension)) {

            clearCoverImage();

            alert(
                'صورة الغلاف يجب أن تكون PNG أو JPG أو JPEG أو WEBP.'
            );

            return;

        }


        if (file.size > MAX_FILE_SIZE) {

            clearCoverImage();

            alert(
                'الحد الأقصى لحجم صورة الغلاف هو 5 ميجابايت.'
            );

            return;

        }


        coverImageFileName.textContent =
            file.name;

        coverImageFileSize.textContent =
            formatFileSize(file.size);

        coverImageFileRow.hidden = false;

    });


    removeCoverImage.addEventListener(
        'click',
        clearCoverImage
    );


    /* =========================================================
       SUBMIT
    ========================================================= */

    const form =
        document.getElementById('deanshipForm');

    const saveBtn =
        document.getElementById('saveBtn');


    form.addEventListener('submit', () => {

        saveBtn.disabled = true;

        saveBtn.textContent =
            'جارٍ إضافة الكلية / العمادة...';

    });

});

</script>

</body>
</html>
