<header class="site-header">
  <div class="nav-inner">
    <a href="{{ route('home') }}" class="brand-mark">
      <img src="{{ asset('assets/logo.png') }}" alt="NextStep AI" class="brand-logo">
      <div class="brand-text">NextStep <span>AI</span></div>
    </a>
    <nav class="main-nav">
      <ul>
        <li><a href="{{ route('home') }}">الرئيسية</a></li>
        <li><a href="{{ route('pages.quiz') }}">الاختبار الذكي</a></li>
        <li><a href="#">الجامعات</a></li>
        <li><a href="#">عن المنصة</a></li>
      </ul>
    </nav>
    <div class="nav-actions">
      @auth
        <a href="{{ route('pages.profile') }}" class="btn-ghost" style="display:inline-flex; align-items:center; gap:6px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
          {{ auth()->user()->name }}
        </a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn-nav-primary" style="background:#ef4444; color:#ffffff; border:none; padding:8px 16px; border-radius:10px; cursor:pointer; font-family:inherit; font-weight:700; font-size:13.5px;">
            تسجيل خروج
          </button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn-ghost">تسجيل دخول</a>
        <a href="{{ route('register') }}" class="btn-nav-primary">
          ابدأ الآن
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
      @endauth
    </div>
  </div>
</header>
