@extends('layouts.app')
@section('title', 'إضافة خدمة')

@section('content')
    <h1>إضافة خدمة جديدة</h1>
    <div class="card" style="max-width:520px;">
        <form action="{{ route('service.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">اسم الخدمة</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="department_id">القسم</label>
                <select name="department_id" id="department_id">
                    <option value="">-- بدون قسم --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->icon }} {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">الوصف</label>
                <textarea name="description" id="description" rows="3" required>{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">السعر (ج.م)</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" required>
            </div>
            <div class="form-group">
                <label for="duration_minutes">المدة (بالدقايق)</label>
                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', 30) }}" required>
            </div>
            <div class="form-group">
                <label for="is_active">الحالة</label>
                <select name="is_active" id="is_active">
                    <option value="1">مفعّلة</option>
                    <option value="0">موقوفة</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ</button>
        </form>
    </div>
@endsection
