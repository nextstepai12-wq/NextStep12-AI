@extends('layouts.app')

@section('title', 'تسجيل الدخول — NextStep AI')

@section('css')
<link href="{{ asset('fronted/css/home.css') }}" rel="stylesheet">
<style>
  /* ======================= AUTH CARD ======================= */
  .auth-wrap{
    display:flex;
    align-items:center;
    justify-content:center;
    padding:56px 16px 80px;
    background:var(--light);
    flex:1;
  }
  .auth-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:20px;
    box-shadow:0 14px 36px rgba(23,59,115,0.08);
    max-width:420px;
    width:100%;
    padding:44px 36px 34px;
  }
  .auth-logo{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    margin-bottom:26px;
  }
  .auth-logo svg{width:38px;height:38px;flex-shrink:0;}
  .auth-logo .brand-text{
    font-family:'Poppins',sans-serif;
    font-weight:800;
    font-size:23px;
    color:var(--navy);
  }
  .auth-logo .brand-text span{color:var(--mint);}
  .auth-title{
    text-align:center;
    font-family:'Poppins',sans-serif;
    font-weight:800;
    font-size:22px;
    color:var(--dark);
    margin-bottom:6px;
  }
  .auth-subtitle{
    text-align:center;
    font-size:13.5px;
    color:var(--gray);
    margin-bottom:28px;
  }
  .form-group{margin-bottom:18px;}
  .form-group label{
    display:block;
    font-weight:600;
    font-size:13px;
    color:var(--dark);
    margin-bottom:7px;
  }
  .form-control{
    width:100%;
    padding:12px 16px;
    border:1.5px solid var(--border);
    border-radius:11px;
    font-family:'Cairo',sans-serif;
    font-size:14px;
    color:var(--dark);
    background:#fff;
    transition:border-color .2s ease, box-shadow .2s ease;
  }
  .form-control::placeholder{color:#AAB4C2;}
  .form-control:focus{
    outline:none;
    border-color:var(--blue);
    box-shadow:0 0 0 4px rgba(47,107,255,0.12);
  }
  .form-meta{
    display:flex;
    justify-content:flex-end;
    margin:-8px 0 22px;
  }
  .form-meta a{
    font-size:12.5px;
    color:var(--blue);
    font-weight:600;
  }
  .form-meta a:hover{text-decoration:underline;}
  .btn-submit{
    width:100%;
    padding:14px;
    border:none;
    border-radius:999px;
    background:linear-gradient(90deg, var(--blue), var(--cyan));
    color:#fff;
    font-family:'Cairo',sans-serif;
    font-weight:700;
    font-size:15px;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    box-shadow:0 10px 22px rgba(47,107,255,0.30);
    transition:transform .2s ease;
  }
  .btn-submit svg{width:16px;height:16px;}
  .btn-submit:hover{transform:translateY(-2px);}
  .auth-footer-text{
    text-align:center;
    font-size:13px;
    color:var(--gray);
    margin-top:22px;
  }
  .auth-footer-text a{
    color:var(--blue);
    font-weight:700;
  }
  .auth-footer-text a:hover{text-decoration:underline;}
  .text-danger{color:#e3342f;font-size:12px;margin-top:5px;}
  .alert-danger{background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;font-size:14px;}
</style>
@endsection

@section('content')
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo">
      <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M24 6L4 15L24 24L44 15L24 6Z" fill="#173B73"/>
        <path d="M12 20V30C12 30 16 36 24 36C32 36 36 30 36 30V20L24 25.5L12 20Z" fill="#35D0FF"/>
        <circle cx="42" cy="17" r="2.5" fill="#48E6B0"/>
        <line x1="42" y1="17" x2="42" y2="27" stroke="#48E6B0" stroke-width="2"/>
      </svg>
      <div class="brand-text">NextStep <span>AI</span></div>
    </div>

    <h1 class="auth-title">أهلاً بعودتك</h1>
    <p class="auth-subtitle">سجّل دخولك للمتابعة إلى حسابك</p>

    @if(session('error'))
      <div class="alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="email">البريد الإلكتروني</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="أدخل بريدك الإلكتروني" required>
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label for="password">كلمة المرور</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة المرور" required>
        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
      </div>

      <div class="form-meta">
        <a href="#">نسيت كلمة المرور؟</a>
      </div>

      <button type="submit" class="btn-submit">
        تسجيل الدخول
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </button>
    </form>

    <p class="auth-footer-text">ليس لديك حساب؟ <a href="{{ route('register') }}">أنشئ واحداً</a></p>
  </div>
</div>
@endsection
