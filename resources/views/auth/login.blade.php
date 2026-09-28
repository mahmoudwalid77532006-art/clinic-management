@extends('layouts.app')
@section('title', 'تسجيل الدخول')
@section('container-class', 'wide')

@section('content')
<div class="auth-split">
    <div class="auth-panel">
        <div class="brand-line"><img src="{{ asset('images/logo.svg') }}" alt=""> عيادة الشفاء</div>
        <div>
            <h2>أهلًا بعودتك 👋</h2>
            <p class="tag">سجّل دخولك وتابع مواعيدك وزياراتك وروشتاتك من مكان واحد آمن.</p>
            <div class="feat">
                <div>📅 <span>تابع حجوزاتك أول بأول</span></div>
                <div>💊 <span>وصول سريع لروشتاتك وسجلك الطبي</span></div>
                <div>🔒 <span>بياناتك محفوظة ومحمية بالكامل</span></div>
            </div>
        </div>
        <span style="font-size:13px;color:#8fc7bf;">© {{ date('Y') }} عيادة الشفاء</span>
    </div>

    <div class="auth-form-side">
        <div class="auth-card">
            <h1>تسجيل الدخول</h1>
            <p class="hint">أدخل بياناتك للمتابعة إلى حسابك.</p>

            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="form-group field">
                    <label for="email">البريد الإلكتروني</label>
                    <span class="fi">✉️</span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="example@mail.com">
                </div>
                <div class="form-group field">
                    <label for="password">كلمة المرور</label>
                    <span class="fi">🔑</span>
                    <input type="password" name="password" id="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-lg" style="width:100%;">دخول</button>
            </form>

            <p class="auth-switch">مفيش حساب لسه؟ <a href="{{ route('register') }}"><b>أنشئ حساب جديد</b></a></p>
        </div>
    </div>
</div>
@endsection
