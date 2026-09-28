@extends('layouts.app')
@section('title', 'إضافة قسم')

@section('content')
    <h1>إضافة قسم جديد</h1>
    <div class="card" style="max-width:520px;">
        <form action="{{ route('department.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">اسم القسم</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="مثلاً: أسنان" required>
            </div>
            <div class="form-group">
                <label for="icon">أيقونة (إيموجي)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="🦷" maxlength="10">
            </div>
            <div class="form-group">
                <label for="description">وصف مختصر</label>
                <textarea name="description" id="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="is_active">الحالة</label>
                <select name="is_active" id="is_active">
                    <option value="1">مفعّل</option>
                    <option value="0">موقوف</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ</button>
        </form>
    </div>
@endsection
