@extends('layouts.app')
@section('title', 'إضافة مستخدم')

@section('content')
    <h1>إضافة مستخدم</h1>
    <div class="card" style="max-width:480px;">
        <p style="color:var(--muted);font-size:14px;">
            دي لإنشاء حسابات "مدير" أو "استقبال" بس. حسابات المريض والدكتور بتتعمل من صفحة "حساب جديد" عشان تترابط ببياناتها صح.
        </p>
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">الاسم</label>
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
            <div class="form-group">
                <label for="role">الدور</label>
                <select name="role" id="role">
                    <option value="admin">مدير</option>
                    <option value="receptionist">استقبال</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ</button>
        </form>
    </div>
@endsection
