const USE_MOCK_DATA = true;
const API_BASE_URL = 'http://127.0.0.1:8000/api';
const ASSETS_BASE = '../assets/universities';

// عدد العناصر اللي تظهر مباشرة قبل ما يطلع زر "شاهد المزيد"
const DEANSHIPS_PREVIEW_LIMIT = 2;
const MAJORS_PREVIEW_LIMIT = 4;

const MOCK_UNIVERSITY_DETAILS = {
  1: {
    name: ' الكلية الجامعية للعلوم التطبيقية ',
    location: 'غزة، فلسطين',
    sector: 'حكومية',
    students_count: 22000,
    majors_count: 74,
    deanships_count: 12,
    description: 'جامعة النجاح الوطنية من أعرق وأكبر الجامعات الفلسطينية، تأسست سنة 1918 وتضم عشرات الكليات والبرامج الأكاديمية على مستوى البكالوريوس والدراسات العليا.',
    vision_mission: 'الريادة والتميز بالتعليم والبحث العلمي خدمةً للمجتمع الفلسطيني.',
    website_url: 'https://www.najah.edu',

    // ===== مستوى الكليات =====
    // كل كلية بتضم عمادة أو أكتر من العمادات أدناه (عن طريق college_id).
    colleges: [
      {
        id: 1,
        name: 'كلية العلوم الهندسية والتقنية',
        description: 'تضم عمادات الحاسوب وتكنولوجيا المعلومات والهندسة.',
        cover_image: 'https://picsum.photos/id/60/600/400',
      },
      {
        id: 2,
        name: 'كلية العلوم الصحية',
        description: 'تضم عمادات الطب والتمريض والصيدلة.',
        cover_image: 'https://picsum.photos/id/1050/600/400',
      },
      {
        id: 3,
        name: 'كلية الأعمال والاقتصاد',
        description: 'تضم عمادات إدارة الأعمال والمحاسبة والاقتصاد.',
        cover_image: 'https://picsum.photos/id/1070/600/400',
      },
    ],

    // ===== مستوى العمادات =====
    // ملاحظة: مو كل عمادة لازم تتبع كلية. لو college_id قيمتها null
    // (متل عمادة الدراسات العليا تحت) فهي "عمادة عامة" مستقلة، وبتظل
    // ظاهرة بشكل طبيعي بقائمة العمادات، بس ما بتظهر تحت أي كلية بالذات.
    deanships_faculties: [
      {
        id: 1,
        type: 'faculty',
        college_id: 1,
        name: 'كلية الهندسة وتكنولوجيا المعلومات',
        description: 'برامج بالحاسوب والهندسة والاتصالات.',
        dean_name: 'د. أحمد سلامة',
        email: 'eng@najah.edu',
        cover_image: 'https://picsum.photos/id/1/600/400'
      },
      {
        id: 2,
        type: 'faculty',
        college_id: 2,
        name: 'كلية الطب والعلوم الصحية',
        description: 'برامج الطب والتمريض والصيدلة.',
        dean_name: 'د. ليلى حمدان',
        email: 'medicine@najah.edu',
        cover_image: 'https://picsum.photos/id/1050/600/400'
      },
      {
        id: 3,
        type: 'faculty',
        college_id: 3,
        name: 'كلية الاقتصاد والعلوم الإدارية',
        description: 'برامج إدارة الأعمال والمحاسبة والاقتصاد.',
        dean_name: 'د. سامر عودة',
        email: 'business@najah.edu',
        cover_image: 'https://picsum.photos/id/1070/600/400'
      },
      {
        id: 4,
        type: 'deanship',
        college_id: null,
        name: 'عمادة الدراسات العليا',
        description: 'تشرف على برامج الماجستير والدكتوراة بمختلف التخصصات، وما بتتبع كلية محددة.',
        dean_name: 'د. منى عودة',
        email: 'graduate@najah.edu',
        cover_image: 'https://picsum.photos/id/180/600/400'
      },
    ],
  },
};

function getFallbackMockUniversity(id) {
  return {
    name: 'جامعة تجريبية #' + id,
    location: 'فلسطين',
    sector: 'حكومية',
    students_count: 5000,
    majors_count: 20,
    deanships_count: 4,
    description: 'بيانات تجريبية لعرض واجهة الصفحة.',
    vision_mission: 'رؤية تجريبية.',
    website_url: 'https://example.com',
    colleges: [],
    deanships_faculties: [],
  };
}

const tabs = document.querySelectorAll('.uni-tab');
const panels = document.querySelectorAll('.uni-panel');

function activateTab(target){
  tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === target));
  panels.forEach(p => { p.style.display = (p.dataset.panel === target) ? 'block' : 'none'; });

  const tabsContainer = document.getElementById('tabsContainer');
  if (tabsContainer) {
    const offset = 20;
    const bodyRect = document.body.getBoundingClientRect().top;
    const elementRect = tabsContainer.getBoundingClientRect().top;
    const elementPosition = elementRect - bodyRect;
    const offsetPosition = elementPosition - offset;

    window.scrollTo({
      top: offsetPosition,
      behavior: 'smooth'
    });
  }
}

tabs.forEach(tab => tab.addEventListener('click', () => activateTab(tab.dataset.tab)));
document.querySelectorAll('.uni-tab-jump').forEach(btn => {
  btn.addEventListener('click', () => activateTab(btn.dataset.jump));
});

function getUniversityIdFromUrl() {
  return new URLSearchParams(window.location.search).get('id') || '1';
}

function formatCount(n) {
  if (n === null || n === undefined) return '—';
  if (n >= 1000) return '+' + Math.round(n / 1000) + 'K';
  return String(n);
}

function renderDeanshipCard(d) {
  return `
    <div class="deanship-card" data-deanship-id="${d.id}">
      <div class="deanship-cover">
        <img src="${d.cover_image || ''}" alt="" ${d.cover_image ? '' : 'style="display:none;"'}>
      </div>
      <div class="deanship-body">
        <span class="deanship-type-badge">${d.type === 'faculty' ? 'كلية' : 'عمادة'}</span>
        <h4>${d.name}</h4>
        <p class="deanship-desc">${d.description || 'ما في وصف متوفر.'}</p>
        <div class="deanship-meta">
          <span>${d.dean_name || '—'}</span>
          <span>${d.email || '—'}</span>
        </div>
        <button class="btn-view-majors" type="button">عرض التخصصات التابعة</button>
      </div>
    </div>`;
}

/* ======================= مستوى الكليات (College → Deanship) ======================= */
// بيانات الجامعة الحالية بالذاكرة، تنعبى بـ renderUniversityDetails
// ومنستخدمها هون عشان نربط الكليات بعدد العمادات التابعة إلها ونفلتر بينهم.
let currentUniColleges = [];
let currentUniDeanships = [];

function renderCollegeCard(c) {
  const relatedCount = currentUniDeanships.filter(d => d.college_id === c.id).length;
  return `
    <div class="deanship-card college-card" data-college-id="${c.id}">
      <div class="deanship-cover">
        <img src="${c.cover_image || ''}" alt="" ${c.cover_image ? '' : 'style="display:none;"'}>
      </div>
      <div class="deanship-body">
        <span class="deanship-type-badge college-type-badge">كلية</span>
        <h4>${c.name}</h4>
        <p class="deanship-desc">${c.description || 'ما في وصف متوفر.'}</p>
        <div class="deanship-meta">
          <span>${relatedCount} ${relatedCount === 1 ? 'عمادة تابعة' : 'عمادات تابعة'}</span>
        </div>
        <button class="btn-view-majors btn-view-deanships" type="button">عرض العمادات التابعة</button>
      </div>
    </div>`;
}

// بتبني قائمة الفلترة (Dropdown) فوق شبكة العمادات: "الكل" + كل كلية + "عمادات عامة"
// لو في عمادة واحدة ع الأقل مش تابعة لأي كلية (college_id null).
// الفلتر كامل بيظهر فقط إذا الجامعة عندها كليات فعلاً.
function renderDeanshipsFilterChips() {
  const bar = document.getElementById('deanshipsFilterBar');
  const select = document.getElementById('deanshipsFilterSelect');

  if (!currentUniColleges.length) {
    bar.style.display = 'none';
    return;
  }

  const hasGeneralDeanships = currentUniDeanships.some(d => !d.college_id);

  let optionsHTML = `<option value="all">الكل</option>`;
  optionsHTML += currentUniColleges.map(c =>
    `<option value="${c.id}">${c.name}</option>`
  ).join('');
  if (hasGeneralDeanships) {
    optionsHTML += `<option value="none">عمادات عامة (غير تابعة لكلية)</option>`;
  }

  select.innerHTML = optionsHTML;
  select.value = 'all';
  bar.style.display = 'flex';
}

// بتفلتر وترسم شبكة العمادات حسب كلية معينة.
// collegeKey: 'all' لكل العمادات، 'none' للعمادات المستقلة (بدون كلية)، أو id الكلية.
function filterDeanshipsByCollege(collegeKey) {
  const select = document.getElementById('deanshipsFilterSelect');
  if (select) select.value = String(collegeKey);

  const filtered = currentUniDeanships.filter(d => {
    if (collegeKey === 'all') return true;
    if (collegeKey === 'none') return !d.college_id;
    return String(d.college_id) === String(collegeKey);
  });

  const grid = document.getElementById('deanshipsGrid');
  if (filtered.length) {
    grid.innerHTML = filtered.map(renderDeanshipCard).join('');
  } else {
    grid.innerHTML = collegeKey === 'all'
      ? '<div class="no-results">ما في عمادات مضافة حالياً.</div>'
      : '<div class="no-results">ما في عمادات مطابقة لهاي الكلية حالياً.</div>';
  }

  setupShowMore('deanshipsGrid', '.deanship-card', DEANSHIPS_PREVIEW_LIMIT, 'كل العمادات والكليات');
}

document.getElementById('deanshipsFilterSelect').addEventListener('change', (e) => {
  filterDeanshipsByCollege(e.target.value);
});

// زر "عرض العمادات التابعة" داخل كرت الكلية: بينقل لتبويب العمادات
// ويفلترهم مباشرة على هاي الكلية بالذات.
document.getElementById('collegesGrid').addEventListener('click', (e) => {
  const btn = e.target.closest('.btn-view-deanships');
  if (!btn) return;

  const card = btn.closest('.college-card');
  if (!card) return;

  const collegeId = card.dataset.collegeId;
  activateTab('deanships');
  filterDeanshipsByCollege(collegeId);
});

/* ======================= منطق النافذة المنبثقة (Modal) ======================= */
const genericModal = document.getElementById('genericModal');
const modalTitleEl = document.getElementById('modalTitle');
const modalGridEl = document.getElementById('modalGrid');
const modalCloseBtn = document.getElementById('modalCloseBtn');

function openModal(title, itemsHTML) {
  modalTitleEl.textContent = title;
  modalGridEl.innerHTML = itemsHTML;
  genericModal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  genericModal.classList.remove('open');
  document.body.style.overflow = '';
}

modalCloseBtn.addEventListener('click', closeModal);
genericModal.addEventListener('click', (e) => {
  if (e.target === genericModal) closeModal();
});
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeModal();
});

/* ======================= منطق نافذة "نسبة توافقك مع الجامعة" ======================= */
const MATCH_STORAGE_KEY = 'nextstep_quiz_result';

const matchModalOverlay = document.getElementById('matchModalOverlay');
const matchModalClose = document.getElementById('matchModalClose');
const matchTriggerBtn = document.getElementById('matchTriggerBtn');

const matchStateFound = document.getElementById('matchStateFound');
const matchStateGeneric = document.getElementById('matchStateGeneric');
const matchStateEmpty = document.getElementById('matchStateEmpty');

const tierLabels = { high: 'توافق عالي', good: 'توافق جيد', medium: 'توافق متوسط' };

function openMatchModal() {
  matchModalOverlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeMatchModal() {
  matchModalOverlay.classList.remove('open');
  document.body.style.overflow = '';
}

matchModalClose.addEventListener('click', closeMatchModal);
matchModalOverlay.addEventListener('click', (e) => {
  if (e.target === matchModalOverlay) closeMatchModal();
});
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeMatchModal();
});

function getStoredQuizResult() {
  try {
    const raw = localStorage.getItem(MATCH_STORAGE_KEY);
    return raw ? JSON.parse(raw) : null;
  } catch (err) {
    return null;
  }
}

function prepareMatchModal() {

  [matchStateFound, matchStateGeneric, matchStateEmpty]
    .forEach(el => el.style.display = 'none');

  const result = getStoredQuizResult();
  const currentId = parseInt(getUniversityIdFromUrl(), 10);

  // الحالة 3: ما أخدت الاستبيان أصلاً
  if (!result) {
    matchStateEmpty.style.display = 'block';
    return;
  }

  const matchedUni =
    (result.universities || []).find(u => u.id === currentId);

  // الحالة 1: عندنا نسبة توافق محسوبة مع هاي الجامعة بالذات
  if (matchedUni && matchedUni.percent !== null && matchedUni.percent !== undefined) {

    document.getElementById('matchPct').innerHTML =
      `${matchedUni.percent}<span>%</span>`;

    const tierLabelEl = document.getElementById('matchTierLabel');
    tierLabelEl.textContent =
      matchedUni.tierLabel || tierLabels[matchedUni.tier] || '';
    tierLabelEl.className = `match-modal-tier tier-${matchedUni.tier}`;

    document.getElementById('matchMajorName').textContent =
      (result.topMajor && result.topMajor.name) || '—';

    document.getElementById('matchMajorDesc').textContent =
      (result.topMajor && result.topMajor.description) || '';

    matchStateFound.style.display = 'block';
    return;
  }

  // الحالة 2: أخدت الاستبيان بس هاي الجامعة مش ضمن نتائجها
  document.getElementById('matchGenericMajor').textContent =
    (result.topMajor && result.topMajor.name) || '—';

  document.getElementById('matchGenericPercent').textContent =
    `${(result.topMajor && result.topMajor.percent) ?? '—'}%`;

  matchStateGeneric.style.display = 'block';
}

matchTriggerBtn.addEventListener('click', () => {
  prepareMatchModal();
  openMatchModal();
});

/**
 * تعرض أول N عنصر من شبكة معينة، وتخفي الباقي، وتضيف زر "شاهد المزيد"
 * بعرض كامل يفتح نافذة منبثقة فيها كل العناصر.
 */
function setupShowMore(containerId, itemSelector, limit, modalTitle) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const oldBtn = container.querySelector('.show-more-btn');
  if (oldBtn) oldBtn.remove();

  const items = Array.from(container.querySelectorAll(itemSelector));
  if (!items.length) return;

  items.forEach((item, idx) => {
    item.style.display = idx < limit ? '' : 'none';
  });

  if (items.length > limit) {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'show-more-btn';
    btn.textContent = `شاهد المزيد (${items.length - limit}+)`;
    btn.addEventListener('click', () => {
      const wrapper = document.createElement('div');
      items.forEach(item => wrapper.appendChild(item.cloneNode(true)));
      openModal(modalTitle, wrapper.innerHTML);
    });
    container.appendChild(btn);
  }
}

/* ======================= فلترة التخصصات: بحث نصي + Dropdown كلية سوا ======================= */

// بتبني خيارات Dropdown الكليات بتبويب التخصصات اعتماداً على أسماء الكليات
// الموجودة فعلياً جوا كروت التخصصات (major-college).
function populateMajorsCollegeFilter() {
  const select = document.getElementById('majorCollegeFilter');
  if (!select) return;

  const allMajors = Array.from(document.querySelectorAll('#majorsGrid .major-card'));
  const uniqueColleges = [...new Set(
    allMajors.map(m => {
      const el = m.querySelector('.major-college');
      return el ? el.textContent.trim() : '';
    }).filter(Boolean)
  )];

  let optionsHTML = `<option value="all">كل الكليات</option>`;
  optionsHTML += uniqueColleges.map(c => `<option value="${c}">${c}</option>`).join('');
  select.innerHTML = optionsHTML;
}

// بتطبق فلترة موحدة على شبكة التخصصات: نص البحث + الكلية المختارة سوا.
function applyMajorsFilter() {
  const q = document.getElementById('majorSearch').value.trim();
  const collegeFilter = document.getElementById('majorCollegeFilter').value;

  const allMajors = Array.from(document.querySelectorAll('#majorsGrid .major-card'));
  let visibleCount = 0;

  allMajors.forEach(card => {
    const name = card.dataset.name || '';
    const collegeEl = card.querySelector('.major-college');
    const college = collegeEl ? collegeEl.textContent.trim() : '';

    const matchesText = name.includes(q) || college.includes(q);
    const matchesCollege = collegeFilter === 'all' || college === collegeFilter;

    const match = matchesText && matchesCollege;
    card.style.display = match ? '' : 'none';
    if (match) visibleCount++;
  });

  document.getElementById('majorsCount').textContent = `${visibleCount} تخصصات`;
}

document.getElementById('majorSearch').addEventListener('input', applyMajorsFilter);
document.getElementById('majorCollegeFilter').addEventListener('change', applyMajorsFilter);

// بتفلتر تخصصات على كلية/عمادة معينة بالاسم، وبتصفّر البحث النصي.
// مستخدمة من زر "عرض التخصصات التابعة" جوا كرت العمادة.
function filterMajorsByCollegeName(collegeName) {
  document.getElementById('majorSearch').value = '';
  document.getElementById('majorCollegeFilter').value = collegeName;
  applyMajorsFilter();

  const showMoreBtn = document.querySelector('#majorsGrid .show-more-btn');
  if (showMoreBtn) showMoreBtn.style.display = 'none';
}

/* ======================= زر "عرض التخصصات التابعة" داخل كرت العمادة: بينقل لتبويب التخصصات ======================= */
document.getElementById('deanshipsGrid').addEventListener('click', (e) => {
  const btn = e.target.closest('.btn-view-majors');
  if (!btn) return;

  const card = btn.closest('.deanship-card');
  if (!card) return;

  const collegeName = card.querySelector('h4').textContent.trim();

  activateTab('majors');
  filterMajorsByCollegeName(collegeName);
});

/* ======================= أزرار الشريط السفلي: حفظ / مقارنة / استكشاف (إضافة جديدة) ======================= */
let isSaved = false;
let isCompared = false;
const saveBtn = document.getElementById('saveBtn');
const compareBtn = document.getElementById('compareBtn');

saveBtn.addEventListener('click', () => {
  isSaved = !isSaved;
  saveBtn.classList.toggle('saved', isSaved);
  saveBtn.querySelector('span').textContent = isSaved ? 'تم الحفظ' : 'حفظ الجامعة';
});
compareBtn.addEventListener('click', () => {
  isCompared = !isCompared;
  compareBtn.classList.toggle('compared', isCompared);
  compareBtn.querySelector('span').textContent = isCompared ? 'أُضيفت للمقارنة' : 'مقارنة';
});
document.getElementById('exploreBtn').addEventListener('click', () => activateTab('majors'));

async function loadUniversityDetails() {
  const id = getUniversityIdFromUrl();
  let uni = USE_MOCK_DATA ? (MOCK_UNIVERSITY_DETAILS[id] || getFallbackMockUniversity(id)) : null;

  if (!USE_MOCK_DATA) {
    try {
      const response = await fetch(`${API_BASE_URL}/universities/${id}`);
      const result = await response.json();
      if (response.ok && result.status === 'success') uni = result.data;
    } catch (err) { console.error(err); }
  }

  if (uni) renderUniversityDetails(uni, id);

  // التخصصات ثابتة بالـ HTML، فمنفعّل زر "شاهد المزيد" فيها مباشرة
  setupShowMore('majorsGrid', '.major-card', MAJORS_PREVIEW_LIMIT, 'كل التخصصات');
  populateMajorsCollegeFilter();
}

function renderUniversityDetails(uni, id) {
  document.title = `${uni.name} — NextStep AI`;
  document.getElementById('uniName').textContent = uni.name;
  document.getElementById('uniDescription').textContent = uni.description || 'ما في وصف متوفر حالياً.';
  document.getElementById('uniLocation').textContent = uni.location || 'غير محدد';
  document.getElementById('factLocationValue').textContent = uni.location || 'غير محدد';
  document.getElementById('factSectorValue').textContent = uni.sector || 'حكومية';

  if (uni.vision_mission) {
    document.getElementById('uniVisionMission').textContent = uni.vision_mission;
    document.getElementById('uniVisionSection').style.display = 'block';
  }

  if (uni.website_url) {
    const link = document.getElementById('uniWebsiteLink');
    link.href = uni.website_url;
    link.textContent = uni.website_url.replace(/^https?:\/\//, '');
    document.getElementById('uniWebsiteRow').style.display = 'inline-flex';
    document.getElementById('contactWebsite').textContent = uni.website_url;
  }

  document.getElementById('statDeanships').textContent = uni.deanships_count ?? 0;
  document.getElementById('statMajors').textContent = uni.majors_count ?? 0;
  document.getElementById('statStudents').textContent = formatCount(uni.students_count);
  document.getElementById('uniDeanshipsCount').textContent = uni.deanships_count ?? 0;
  document.getElementById('contactLocation').textContent = uni.location || 'غير محدد';

  // بناء المسار المباشر لمجلد صور الجامعة
  const universityAssetsFolder = `${ASSETS_BASE}/${id}`;

  // 1. ضبط صورة الغلاف
  const coverImg = document.getElementById('uniCoverImg');
  if (coverImg) {
    coverImg.src = `${universityAssetsFolder}/cover.jpg`;
    coverImg.style.display = 'block';

    coverImg.onerror = () => {
      coverImg.style.display = 'none';
    };
  }

  // 2. ضبط اللوجو
  const logoImg = document.getElementById('uniLogo');
  const logoFallback = document.getElementById('uniLogoFallback');
  if (logoImg) {
    logoImg.src = `${universityAssetsFolder}/logo.png`;
    logoImg.style.display = 'block';
    if (logoFallback) logoFallback.style.display = 'none';

    logoImg.onerror = () => {
      logoImg.style.display = 'none';
      if (logoFallback) logoFallback.style.display = 'block';
    };
  }

  // ===== الكليات والعمادات =====
  currentUniColleges = uni.colleges || [];
  currentUniDeanships = uni.deanships_faculties || [];

  const collegesGrid = document.getElementById('collegesGrid');
  collegesGrid.innerHTML = currentUniColleges.length
    ? currentUniColleges.map(renderCollegeCard).join('')
    : '<div class="no-results">ما في كليات مضافة حالياً.</div>';
  setupShowMore('collegesGrid', '.college-card', DEANSHIPS_PREVIEW_LIMIT, 'كل الكليات');

  renderDeanshipsFilterChips();
  filterDeanshipsByCollege('all');
}

loadUniversityDetails();


document.getElementById('deanshipSearch').addEventListener('input', (e) => {
  const q = e.target.value.trim();
  const cards = document.querySelectorAll('#deanshipsGrid .deanship-card');
  cards.forEach(card => {
    const name = card.querySelector('h4')?.textContent.trim() || '';
    card.style.display = name.includes(q) ? '' : 'none';
  });
});