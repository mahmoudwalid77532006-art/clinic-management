@extends('layouts.app')
@section('title', 'تعديل القسم')

@section('content')
    <h1>تعديل قسم {{ $department->name }}</h1>
    <div class="card" style="max-width:520px;">
        <form action="{{ route('department.update', $department) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="name">اسم القسم</label>
                <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" required>
            </div>
            <div class="form-group">
                <label for="icon">أيقونة (إيموجي)</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon', $department->icon) }}" maxlength="10">
            </div>
            <div class="form-group">
                <label for="description">وصف مختصر</label>
                <textarea name="description" id="description" rows="3">{{ old('description', $department->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="is_active">الحالة</label>
                <select name="is_active" id="is_active">
                    <option value="1" {{ $department->is_active ? 'selected' : '' }}>مفعّل</option>
                    <option value="0" {{ ! $department->is_active ? 'selected' : '' }}>موقوف</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ التعديلات</button>
        </form>
    </div>
@endsection
