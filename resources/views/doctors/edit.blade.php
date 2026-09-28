@extends('layouts.app')
@section('title', 'تعديل الطبيب')

@section('content')
    <h1>تعديل بيانات {{ $doctor->user->name }}</h1>
    <div class="card" style="max-width:520px;">
        <form action="{{ route('doctor.update', $doctor) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="user_id" value="{{ $doctor->user_id }}">
            <div class="form-group">
                <label for="department_id">القسم</label>
                <select name="department_id" id="department_id">
                    <option value="">-- بدون قسم --</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id', $doctor->department_id) == $department->id ? 'selected' : '' }}>
                            {{ $department->icon }} {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="specialty">التخصص</label>
                <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $doctor->specialty) }}" required>
            </div>
            <div class="form-group">
                <label for="bio">نبذة</label>
                <textarea name="bio" id="bio" rows="3">{{ old('bio', $doctor->bio) }}</textarea>
            </div>
            <div class="form-group">
                <label for="slot_duration_minutes">مدة الكشف (بالدقايق)</label>
                <input type="number" name="slot_duration_minutes" id="slot_duration_minutes" value="{{ old('slot_duration_minutes', $doctor->slot_duration_minutes) }}">
            </div>
            <div class="form-group">
                <label for="is_active">الحالة</label>
                <select name="is_active" id="is_active">
                    <option value="1" {{ $doctor->is_active ? 'selected' : '' }}>نشط</option>
                    <option value="0" {{ ! $doctor->is_active ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ التعديلات</button>
        </form>
    </div>
@endsection
