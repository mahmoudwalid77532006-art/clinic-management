@extends('layouts.app')
@section('title', 'إنشاء حساب')
@section('container-class', 'wide')

@section('content')
<div class="auth-split">
    <div class="auth-panel">
        <div class="brand-line"><img src="{{ asset('images/logo.svg') }}" alt=""> عيادة الشفاء</div>
        <div>
            <h2>ابدأ رحلتك معانا ✨</h2>
            <p class="tag">حساب واحد يفتحلك حجز المواعيد والسجل الطبي والروشتات الإلكترونية.</p>
            <div class="feat">
                <div>⚡ <span>حجز موعد في أقل من دقيقة</span></div>
                <div>👨‍⚕️ <span>أطباء متخصصون في كل الأقسام</span></div>
                <div>🔒 <span>خصوصية كاملة لبياناتك</span></div>
            </div>
        </div>
        <span style="font-size:13px;color:#8fc7bf;">© {{ date('Y') }} عيادة الشفاء</span>
    </div>

    <div class="auth-form-side">
        <div class="auth-card">
            <h1>إنشاء حساب جديد</h1>
            <p class="hint">املأ البيانات التالية للبدء.</p>
            <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="form-group">
                    <label>أنا مين بالظبط؟</label>
                    <div class="type-switch">
                        <label>
                            <input type="radio" name="account_type" value="patient"
                                {{ old('account_type', 'patient') === 'patient' ? 'checked' : '' }}
                                onclick="document.getElementById('patient-fields').style.display='block';document.getElementById('doctor-fields').style.display='none';">
                            🧑‍🤝‍🧑 مريض
                        </label>
                        <label>
                            <input type="radio" name="account_type" value="doctor"
                                {{ old('account_type') === 'doctor' ? 'checked' : '' }}
                                onclick="document.getElementById('patient-fields').style.display='none';document.getElementById('doctor-fields').style.display='block';">
                            👨‍⚕️ دكتور
                        </label>
                    </div>
                </div>

            <div class="form-group">
                <label for="name">الاسم بالكامل</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div id="patient-fields" style="display: {{ old('account_type', 'patient') === 'doctor' ? 'none' : 'block' }};">
                <div class="form-group">
                    <label for="phone">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="date_of_birth">تاريخ الميلاد</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
                </div>
                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}">
                </div>
                <div class="form-group">
                    <label for="gender">النوع</label>
                    <select name="gender" id="gender">
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>
            </div>

            <div id="doctor-fields" style="display: {{ old('account_type') === 'doctor' ? 'block' : 'none' }};">
                <div class="form-group">
                    <label for="specialty">التخصص</label>
                    <input type="text" name="specialty" id="specialty" value="{{ old('specialty') }}" placeholder="مثلاً: باطنة، أطفال، عظام">
                </div>
                <div class="form-group">
                    <label for="bio">نبذة تعريفية (اختياري)</label>
                    <textarea name="bio" id="bio" rows="3">{{ old('bio') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-lg" style="width:100%;">إنشاء الحساب</button>
        </form>

            <p class="auth-switch">عندك حساب بالفعل؟ <a href="{{ route('login') }}"><b>سجّل دخول</b></a></p>
        </div>
    </div>
</div>
@endsection
