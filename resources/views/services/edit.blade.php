@extends('layouts.app')
@section('title', 'تعديل الخدمة')

@section('content')
    <h1>تعديل {{ $service->name }}</h1>
    <div class="card" style="max-width:520px;">
        <form action="{{ route('service.update', $service) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label for="name">اسم الخدمة</label>
                <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}" required>
            </div>
            <div class="form-group">
                <label for="department_id">القسم</label>
                <select name="department_id" id="department_id">
                    <option value="">-- بدون قسم --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id', $service->department_id) == $department->id ? 'selected' : '' }}>
                            {{ $department->icon }} {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="description">الوصف</label>
                <textarea name="description" id="description" rows="3" required>{{ old('description', $service->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">السعر (ج.م)</label>
                <input type="number" name="price" id="price" value="{{ old('price', $service->price) }}" required>
            </div>
            <div class="form-group">
                <label for="duration_minutes">المدة (بالدقايق)</label>
                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" required>
            </div>
            <div class="form-group">
                <label for="is_active">الحالة</label>
                <select name="is_active" id="is_active">
                    <option value="1" {{ $service->is_active ? 'selected' : '' }}>مفعّلة</option>
                    <option value="0" {{ ! $service->is_active ? 'selected' : '' }}>موقوفة</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ التعديلات</button>
        </form>
    </div>
@endsection
