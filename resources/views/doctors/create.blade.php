@extends('layouts.app')
@section('title', 'إضافة طبيب')

@section('content')
    <h1>إضافة طبيب</h1>
    <div class="card" style="max-width:520px;">
        <p style="color:var(--muted);font-size:14px;">
            ملحوظة: لازم يكون فيه حساب User موجود بالفعل بدوره "دكتور" عشان تقدر تربطه هنا. أسهل طريقة إن الطبيب يعمل حساب بنفسه من صفحة "حساب جديد".
        </p>
        <form action="{{ route('doctor.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">رقم حساب المستخدم (User ID)</label>
                <input type="number" name="user_id" id="user_id" value="{{ old('user_id') }}" required>
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
                <label for="specialty">التخصص</label>
                <input type="text" name="specialty" id="specialty" value="{{ old('specialty') }}" required>
            </div>
            <div class="form-group">
                <label for="bio">نبذة</label>
                <textarea name="bio" id="bio" rows="3">{{ old('bio') }}</textarea>
            </div>
            <div class="form-group">
                <label for="slot_duration_minutes">مدة الكشف (بالدقايق)</label>
                <input type="number" name="slot_duration_minutes" id="slot_duration_minutes" value="{{ old('slot_duration_minutes', 30) }}">
            </div>
            <button type="submit" class="btn">حفظ</button>
        </form>
    </div>
@endsection
