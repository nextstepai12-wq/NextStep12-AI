@extends('layouts.app')

@section('title', 'نتائج الاستبيان — NextStep AI')

@section('css')
<link href="{{ asset('css/results.css') }}" rel="stylesheet">
<style>
.results-loading, .results-empty {
  text-align: center;
  padding: 60px 20px;
  background: #fff;
  border-radius: 22px;
  border: 1px solid var(--border, #e2e8f0);
  margin-bottom: 30px;
}
.results-spinner {
  width: 44px;
  height: 44px;
  border: 4px solid rgba(47,107,255,0.15);
  border-top-color: var(--blue, #2f6bff);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  margin: 0 auto 16px;
}
@keyframes spin {
  to { transform: rotate(360deg); }
}
.major-detail-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: rgba(255,255,255,0.85);
  margin-top: 10px;
}
</style>
@endsection

@section('content')
<!-- ======================= RESULTS ======================= -->
<div class="results-wrap">
  <div class="results-inner">

    <!-- Loading State -->
    <div class="results-loading" id="resultsLoading">
      <div class="results-spinner"></div>
      <h3 style="color:var(--navy);font-weight:800;font-size:18px;">جاري تحليل نتائج الاستبيان...</h3>
      <p style="color:var(--gray);font-size:13.5px;margin-top:6px;">نحن نقوم الآن بحساب نسب التوافق الدقيقة لتخصصاتك المقترحة</p>
    </div>

    <!-- Empty State (إذا لم يقم بالطالب بأداء الاستبيان) -->
    <div class="results-empty" id="resultsEmpty" style="display:none;">
      <div style="width:64px;height:64px;border-radius:50%;background:rgba(47,107,255,0.1);color:var(--blue);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.6.5 1 1.3 1 2.1V17h6v-1.4c0-.8.4-1.6 1-2.1A6 6 0 0 0 12 3z"/></svg>
      </div>
      <h2 style="font-size:22px;font-weight:800;color:var(--navy);margin-bottom:8px;">لم تُكمل الاستبيان بعد! 🎉</h2>
      <p style="color:var(--gray);font-size:14px;max-width:440px;margin:0 auto 24px;line-height:1.7;">
        أجب على أسئلة الاستبيان الذكي لاكتشاف ميولك وتحديد التخصصات والجامعات الأنسب لشخصيتك.
      </p>
      <a href="{{ route('pages.quiz') }}" class="btn-continue" style="text-decoration:none;">
        ابدأ الاستبيان الآن 🚀
      </a>
    </div>

    <!-- Main Results Content -->
    <div id="resultsContent" style="display:none;">

      <div class="results-head">
        <span class="results-eyebrow">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6L9 17l-5-5"/></svg>
          تم تحليل إجاباتك بنجاح
        </span>
        <h1>نتائج التوصية الأكاديمية الخاصة بك</h1>
        <p>بناءً على إجاباتك في الاستبيان الذكي، حللنا ميولك ومهاراتك ولقينالك أقرب التخصصات المناسبة لشغفك وهدفك المستقبلي</p>
      </div>

      <!-- Top match: main recommended major -->
      <div class="top-match" id="topMatchCard">
        <div class="top-match-info">
          <span class="top-match-tag">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 2l9 4.5-9 4.5-9-4.5 9-4.5z"/><path d="M3 6.5v6c0 2.5 4 4.5 9 4.5s9-2 9-4.5v-6"/></svg>
            <span id="topMatchDeanship">التخصص الأول المقترح</span>
          </span>
          <div class="top-match-name" id="topMatchTitle">...</div>
          <p class="top-match-desc" id="topMatchDesc">...</p>
          <div class="major-detail-item" id="topMatchDetails"></div>
        </div>

        <div class="match-circle">
          <div class="pct"><span id="topMatchPct">0</span><span>%</span></div>
          <div class="pct-label">نسبة التوافق</div>
        </div>
      </div>

      <!-- Other suggested majors -->
      <div class="section-title"><span class="dot"></span>تخصصات مقترحة أخرى تناسبك</div>
      
      <div class="uni-grid" id="recommendationsGrid">
        <!-- يتم تعبئتها ديناميكياً بـ JavaScript -->
      </div>

      <!-- Actions -->
      <div class="results-actions">
        <a href="{{ route('pages.quiz') }}" class="btn-retake" style="text-decoration:none;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
          إعادة الاختبار
        </a>
        <a href="{{ route('universities.index') }}" class="btn-continue" style="text-decoration:none;">
          استكشف الجامعات والتخصصات
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
      </div>

    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
async function loadResults() {
  const loading = document.getElementById('resultsLoading');
  const empty = document.getElementById('resultsEmpty');
  const content = document.getElementById('resultsContent');

  try {
    const response = await fetch('/results/data', {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    const data = await response.json();

    loading.style.display = 'none';

    if (!response.ok || !data.has_results || !data.recommendations || data.recommendations.length === 0) {
      empty.style.display = 'block';
      return;
    }

    content.style.display = 'block';

    const top = data.top_match || data.recommendations[0];

    // تعبئة التخصص الأول المقترح
    document.getElementById('topMatchTitle').textContent = top.title;
    document.getElementById('topMatchPct').textContent = Math.round(top.match_percentage);
    document.getElementById('topMatchDesc').textContent = top.ai_feedback || top.description;
    document.getElementById('topMatchDeanship').textContent = top.deanship_name ? `التخصص الأول المقترح — ${top.deanship_name}` : 'التخصص الأول المقترح';

    let detailHtml = '';
    if (top.total_credit_hours) detailHtml += `<span>⏱️ ${top.total_credit_hours} ساعة معتمدة</span>`;
    if (top.min_high_school_score) detailHtml += `<span style="margin-inline-start:12px;">🎓 معدل التوجيهي: ${top.min_high_school_score}%</span>`;
    document.getElementById('topMatchDetails').innerHTML = detailHtml;

    // تعبئة التخصصات الثانوية المقترحة
    const grid = document.getElementById('recommendationsGrid');
    grid.innerHTML = '';

    const otherRecs = data.recommendations.slice(1);

    if (otherRecs.length === 0) {
      grid.innerHTML = '<div style="grid-column:1/-1;color:var(--gray);font-size:13.5px;text-align:center;">لا توجد تخصصات ثانوية أخرى مستوفية للنسبة حالياً.</div>';
    } else {
      otherRecs.forEach(rec => {
        const card = document.createElement('div');
        card.className = 'uni-card';
        card.innerHTML = `
          <div class="uni-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l9 4.5-9 4.5-9-4.5 9-4.5z"/><path d="M3 6.5v6c0 2.5 4 4.5 9 4.5s9-2 9-4.5v-6"/></svg>
          </div>
          <div class="uni-pct">${Math.round(rec.match_percentage)}<span>%</span></div>
          <div class="uni-bar"><div class="uni-bar-fill" style="width:${Math.round(rec.match_percentage)}%;"></div></div>
          <div class="uni-name">${rec.title}</div>
          <div class="uni-tier-label" style="color:var(--gray);">${rec.deanship_name || 'تخصص جامعي'}</div>
          <p style="font-size:12px;color:var(--gray);margin-top:10px;line-height:1.6;">${rec.ai_feedback || ''}</p>
        `;
        grid.appendChild(card);
      });
    }

  } catch (error) {
    console.error('Error loading results:', error);
    loading.style.display = 'none';
    empty.style.display = 'block';
  }
}

document.addEventListener('DOMContentLoaded', loadResults);
</script>
@endsection
