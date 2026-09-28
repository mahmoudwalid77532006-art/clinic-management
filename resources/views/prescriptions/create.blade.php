@extends('layouts.app')
@section('title', 'إضافة روشتة')

@section('content')
    <h1>إضافة روشتة جديدة</h1>
    <div class="card" style="max-width:560px;">
        <form action="{{ route('prescription.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="visit_id">الزيارة</label>
                <select name="visit_id" id="visit_id" required>
                    <option value="">-- اختر الزيارة --</option>
                    @foreach ($visits as $visit)
                        <option value="{{ $visit->id }}">
                            {{ $visit->patient->full_name }} — {{ $visit->doctor->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="medication_name">اسم الدواء</label>
                <input type="text" name="medication_name" id="medication_name" required>
            </div>
            <div class="form-group">
                <label for="dosage">الجرعة</label>
                <input type="text" name="dosage" id="dosage" placeholder="مثلاً: 500 مج" required>
            </div>
            <div class="form-group">
                <label for="frequency">عدد مرات الاستخدام</label>
                <input type="text" name="frequency" id="frequency" placeholder="مثلاً: مرتين يوميًا" required>
            </div>
            <div class="form-group">
                <label for="duration">المدة</label>
                <input type="text" name="duration" id="duration" placeholder="مثلاً: 7 أيام" required>
            </div>
            <div class="form-group">
                <label for="instructions">تعليمات إضافية</label>
                <textarea name="instructions" id="instructions" rows="2"></textarea>
            </div>
            <button type="submit" class="btn">حفظ</button>
        </form>
    </div>
@endsection
