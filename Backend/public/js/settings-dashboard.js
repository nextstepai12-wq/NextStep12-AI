// ============================================================
// SETTINGS DASHBOARD - JavaScript
// لوحة الإعدادات - التحكم الكامل
// ============================================================

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    console.log('⚙️ Settings Dashboard initialized');

    // ============================================================
    // 1. STEPPER - التنقل بين أقسام الإعدادات
    // ============================================================
    const stepperItems = document.querySelectorAll('.stepper-item-settings');
    const sections = {
        general: document.getElementById('sectionGeneral'),
        universities: document.getElementById('sectionUniversities'),
        ai: document.getElementById('sectionAI'),
        security: document.getElementById('sectionSecurity')
    };

    /**
     * إظهار قسم معين وإخفاء الباقي
     */
    function showSettingsSection(targetId) {
        // إخفاء كل الأقسام
        Object.values(sections).forEach(section => {
            if (section) section.style.display = 'none';
        });

        // إظهار القسم المطلوب
        const targetSection = document.getElementById(targetId);
        if (targetSection) targetSection.style.display = 'block';

        // تحديث الـ Stepper
        stepperItems.forEach(item => {
            const isActive = item.dataset.target === targetId;
            item.classList.toggle('active', isActive);
        });
    }

    // إضافة مستمعات لأزرار الـ Stepper
    stepperItems.forEach(item => {
        item.addEventListener('click', function() {
            const targetId = this.dataset.target;
            showSettingsSection(targetId);
        });
    });

    // إظهار القسم الأول افتراضياً
    showSettingsSection('sectionGeneral');

    // ============================================================
    // 2. TAGS - إدارة العلامات (AI Models & Recommendations)
    // ============================================================
    
    /**
     * إضافة علامة جديدة
     */
    function addTag(containerId, value) {
        const val = value.trim();
        if (!val) return;

        const container = document.getElementById(containerId);
        if (!container) return;

        // التحقق من عدم وجود العلامة مسبقاً
        const existingTags = container.querySelectorAll('.tag-chip');
        for (let tag of existingTags) {
            if (tag.textContent.trim().replace('✕', '').trim() === val) {
                return; // العلامة موجودة بالفعل
            }
        }

        // إنشاء العلامة
        const chip = document.createElement('span');
        chip.className = 'tag-chip';

        const text = document.createTextNode(val);
        chip.appendChild(text);

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'tag-remove';
        button.setAttribute('aria-label', 'حذف');
        button.textContent = '✕';
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            chip.remove();
            console.log(`🗑️ Removed tag: ${val}`);
        });

        chip.appendChild(button);
        container.appendChild(chip);
        console.log(`✅ Added tag: ${val}`);
    }

    // إضافة مستمعات لأزرار الإضافة
    document.querySelectorAll('.tag-add-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = document.getElementById(this.dataset.input);
            if (input) {
                addTag(this.dataset.target, input.value);
                input.value = '';
                input.focus();
            }
        });
    });

    // إضافة مستمعات للـ Enter في حقول الإدخال
    ['modelTagInput', 'recommendTagInput'].forEach(inputId => {
        const input = document.getElementById(inputId);
        if (!input) return;

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const targetId = this.id === 'modelTagInput' ? 'modelTags' : 'recommendTags';
                addTag(targetId, this.value);
                this.value = '';
            }
        });
    });

    // إضافة مستمعات لأزرار الحذف الموجودة مسبقاً
    document.querySelectorAll('.tag-remove').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const chip = this.closest('.tag-chip');
            if (chip) chip.remove();
        });
    });

    // ============================================================
    // 3. TOGGLES - مفاتيح التبديل
    // ============================================================
    document.querySelectorAll('.toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const label = this.closest('.toggle-wrap')?.querySelector('.toggle-label');
            const status = this.checked ? 'مفعّل ✅' : 'غير مفعّل ❌';
            console.log(`🔘 Toggle: ${label?.textContent || 'Unknown'} → ${status}`);
        });
    });

    // ============================================================
    // 4. MODAL - نافذة منبثقة
    // ============================================================
    const modalOverlay = document.getElementById('appModalOverlay');
    const modalIcon = document.getElementById('appModalIcon');
    const modalTitle = document.getElementById('appModalTitle');
    const modalMsg = document.getElementById('appModalMsg');
    const modalActions = document.getElementById('appModalActions');

    /**
     * فتح النافذة المنبثقة
     */
    function openModal({ type = 'success', title, message, confirmText = 'تمام', onConfirm = null }) {
        // تعيين الأيقونة
        modalIcon.className = `app-modal-icon ${type}`;
        modalIcon.textContent = type === 'success' ? '✓' : type === 'error' ? '!' : '?';
        
        modalTitle.textContent = title;
        modalMsg.textContent = message;

        modalActions.innerHTML = '';

        if (onConfirm) {
            // زر إلغاء
            const cancelBtn = document.createElement('button');
            cancelBtn.type = 'button';
            cancelBtn.className = 'app-modal-btn-outline';
            cancelBtn.textContent = 'إلغاء';
            cancelBtn.addEventListener('click', closeModal);

            // زر تأكيد
            const confirmBtn = document.createElement('button');
            confirmBtn.type = 'button';
            confirmBtn.className = `app-modal-btn-primary ${type === 'error' ? 'danger' : ''}`;
            confirmBtn.textContent = confirmText;
            confirmBtn.addEventListener('click', function() {
                closeModal();
                if (typeof onConfirm === 'function') onConfirm();
            });

            modalActions.appendChild(cancelBtn);
            modalActions.appendChild(confirmBtn);
        } else {
            // زر موافق
            const okBtn = document.createElement('button');
            okBtn.type = 'button';
            okBtn.className = 'app-modal-btn-primary';
            okBtn.textContent = confirmText;
            okBtn.addEventListener('click', closeModal);
            modalActions.appendChild(okBtn);
        }

        modalOverlay.classList.add('is-open');
    }

    /**
     * إغلاق النافذة المنبثقة
     */
    function closeModal() {
        modalOverlay.classList.remove('is-open');
    }

    // إغلاق عند النقر على الخلفية
    modalOverlay.addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // إغلاق عند الضغط على Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalOverlay.classList.contains('is-open')) {
            closeModal();
        }
    });

    // ============================================================
    // 5. SAVE - حفظ الإعدادات
    // ============================================================
    const settingsForm = document.getElementById('settingsForm');
    const saveBtn = document.getElementById('saveBtn');

    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // تعطيل الزر وإظهار حالة التحميل
            saveBtn.disabled = true;
            saveBtn.innerHTML = '⏳ جاري الحفظ...';

            // محاكاة حفظ البيانات
            setTimeout(function() {
                // جمع البيانات
                const formData = {
                    platformName: document.getElementById('platformName')?.value || '',
                    platformTagline: document.getElementById('platformTagline')?.value || '',
                    language: document.getElementById('langSelect')?.value || 'ar',
                    timezone: document.getElementById('timezone')?.value || 'Asia/Riyadh',
                    defaultUniversity: document.getElementById('defaultUniversity')?.value || '1',
                    facultyCount: document.getElementById('facultyCount')?.value || '12',
                    deanshipDisplay: document.getElementById('deanshipDisplay')?.value || 'alphabetical',
                    sessionTimeout: document.getElementById('sessionTimeout')?.value || '60',
                    maxLoginAttempts: document.getElementById('maxLoginAttempts')?.value || '5',
                    darkMode: document.querySelector('.toggle')?.checked || false,
                    emailNotifications: document.querySelectorAll('.toggle')[1]?.checked || false,
                    twoFactorAuth: document.querySelectorAll('.toggle')[2]?.checked || false
                };

                console.log('📦 Saved Settings:', formData);

                // عرض رسالة نجاح
                openModal({
                    type: 'success',
                    title: 'تم حفظ الإعدادات بنجاح!',
                    message: 'تم تحديث إعدادات المنصة بنجاح.',
                    confirmText: 'تمام',
                    onConfirm: function() {
                        // إعادة تفعيل الزر
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = `
                            حفظ الإعدادات
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="M5 12h14M13 5l7 7-7 7"/>
                            </svg>
                        `;
                    }
                });
            }, 800);
        });
    }

    // ============================================================
    // 6. RESET - استعادة الإعدادات الافتراضية
    // ============================================================
    const resetBtn = document.getElementById('resetBtn');

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            openModal({
                type: 'error',
                title: 'استعادة الإعدادات الافتراضية',
                message: 'هل أنت متأكد من استعادة جميع الإعدادات إلى القيم الافتراضية؟',
                confirmText: 'نعم، استعادة',
                onConfirm: function() {
                    // إعادة تعيين الحقول
                    const platformName = document.getElementById('platformName');
                    if (platformName) platformName.value = 'NextStep AI';

                    const platformTagline = document.getElementById('platformTagline');
                    if (platformTagline) platformTagline.value = 'ذكاء اصطناعي لمستقبل التعليم';

                    const langSelect = document.getElementById('langSelect');
                    if (langSelect) langSelect.value = 'ar';

                    const timezone = document.getElementById('timezone');
                    if (timezone) timezone.value = 'Asia/Riyadh';

                    const defaultUniversity = document.getElementById('defaultUniversity');
                    if (defaultUniversity) defaultUniversity.value = '2';

                    const facultyCount = document.getElementById('facultyCount');
                    if (facultyCount) facultyCount.value = '12';

                    const deanshipDisplay = document.getElementById('deanshipDisplay');
                    if (deanshipDisplay) deanshipDisplay.value = 'alphabetical';

                    const sessionTimeout = document.getElementById('sessionTimeout');
                    if (sessionTimeout) sessionTimeout.value = '60';

                    const maxLoginAttempts = document.getElementById('maxLoginAttempts');
                    if (maxLoginAttempts) maxLoginAttempts.value = '5';

                    // إعادة تعيين الـ Toggles
                    const toggles = document.querySelectorAll('.toggle');
                    if (toggles.length > 0) {
                        toggles[0].checked = true;  // Dark mode
                    }
                    if (toggles.length > 1) {
                        toggles[1].checked = true;  // Email notifications
                    }
                    if (toggles.length > 2) {
                        toggles[2].checked = false; // 2FA
                    }

                    // إعادة تعيين الـ Tags
                    const modelTags = document.getElementById('modelTags');
                    if (modelTags) {
                        modelTags.innerHTML = `
                            <span class="tag-chip">GPT-4 <button type="button" class="tag-remove">✕</button></span>
                            <span class="tag-chip">Claude 3 <button type="button" class="tag-remove">✕</button></span>
                        `;
                        // إعادة ربط مستمعات الحذف
                        modelTags.querySelectorAll('.tag-remove').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const chip = this.closest('.tag-chip');
                                if (chip) chip.remove();
                            });
                        });
                    }

                    const recommendTags = document.getElementById('recommendTags');
                    if (recommendTags) {
                        recommendTags.innerHTML = `
                            <span class="tag-chip">التخصصات الجامعية <button type="button" class="tag-remove">✕</button></span>
                            <span class="tag-chip">المسارات المهنية <button type="button" class="tag-remove">✕</button></span>
                        `;
                        recommendTags.querySelectorAll('.tag-remove').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const chip = this.closest('.tag-chip');
                                if (chip) chip.remove();
                            });
                        });
                    }

                    console.log('🔄 Reset to default settings');

                    // عرض رسالة نجاح
                    openModal({
                        type: 'success',
                        title: 'تمت الاستعادة',
                        message: 'تم استعادة جميع الإعدادات إلى القيم الافتراضية.',
                        confirmText: 'تمام'
                    });
                }
            });
        });
    }

    // ============================================================
    // 7. KEYBOARD SHORTCUTS
    // ============================================================
    document.addEventListener('keydown', function(e) {
        // Ctrl + S لحفظ الإعدادات
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const saveBtn = document.getElementById('saveBtn');
            if (saveBtn && !saveBtn.disabled) {
                saveBtn.click();
            }
        }

        // Escape لإغلاق الـ Modal
        if (e.key === 'Escape') {
            if (modalOverlay.classList.contains('is-open')) {
                closeModal();
            }
        }
    });

    // ============================================================
    // 8. SETTINGS CARDS (للصفحة الرئيسية)
    // ============================================================
    const settingsCards = document.querySelectorAll('.settings-card');
    settingsCards.forEach(card => {
        card.addEventListener('click', function() {
            const link = this.dataset.href || this.querySelector('a')?.getAttribute('href');
            if (link) {
                window.location.href = link;
            }
        });

        // تأثير hover إضافي
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });

    console.log('✅ Settings Dashboard ready!');
});

// ============================================================
// EXPOSE FUNCTIONS FOR GLOBAL USE
// ============================================================
if (typeof window !== 'undefined') {
    window.Settings = {
        showSettingsSection,
        addTag,
        openModal,
        closeModal
    };
}