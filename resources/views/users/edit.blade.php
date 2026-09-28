@extends('layouts.app')
@section('title', 'تعديل المستخدم')

@section('content')
    <h1>تعديل {{ $user->name }}</h1>
    <div class="card" style="max-width:480px;">
        <form action="{{ route('user.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="password">كلمة مرور جديدة (سيبها فاضية لو مش هتغيّرها)</label>
                <input type="password" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="role">الدور</label>
                <select name="role" id="role">
                    @foreach (['admin' => 'مدير', 'doctor' => 'دكتور', 'receptionist' => 'استقبال', 'patient' => 'مريض'] as $value => $label)
                        <option value="{{ $value }}" {{ $user->role === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn">حفظ التعديلات</button>
        </form>
    </div>
@endsection
