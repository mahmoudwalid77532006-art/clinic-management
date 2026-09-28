@extends('layouts.app')
@section('title', 'إضافة مريض')

@section('content')
    <h1>إضافة مريض</h1>
    <div class="card" style="max-width:520px;">
        <p style="color:var(--muted);font-size:14px;">
            ملحوظة: لازم يكون فيه حساب User موجود بدوره "مريض" عشان تربطه هنا.
        </p>
        <form action="{{ route('patient.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">رقم حساب المستخدم (User ID)</label>
                <input type="number" name="user_id" id="user_id" value="{{ old('user_id') }}" required>
            </div>
            <div class="form-group">
                <label for="full_name">الاسم بالكامل</label>
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required>
            </div>
            <div class="form-group">
                <label for="phone">الهاتف</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">تاريخ الميلاد</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required>
            </div>
            <div class="form-group">
                <label for="address">العنوان</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}">
            </div>
            <div class="form-group">
                <label for="gender">النوع</label>
                <select name="gender" id="gender">
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ</button>
        </form>
    </div>
@endsection
