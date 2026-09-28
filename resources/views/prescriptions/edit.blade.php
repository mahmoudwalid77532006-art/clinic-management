@extends('layouts.app')
@section('title', 'تعديل الروشتة')

@section('content')
    <h1>تعديل روشتة {{ $prescription->medication_name }}</h1>
    <div class="card" style="max-width:560px;">
        <form action="{{ route('prescription.update', $prescription) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="visit_id" value="{{ $prescription->visit_id }}">
            <div class="form-group">
                <label for="medication_name">اسم الدواء</label>
                <input type="text" name="medication_name" id="medication_name" value="{{ old('medication_name', $prescription->medication_name) }}" required>
            </div>
            <div class="form-group">
                <label for="dosage">الجرعة</label>
                <input type="text" name="dosage" id="dosage" value="{{ old('dosage', $prescription->dosage) }}" required>
            </div>
            <div class="form-group">
                <label for="frequency">عدد مرات الاستخدام</label>
                <input type="text" name="frequency" id="frequency" value="{{ old('frequency', $prescription->frequency) }}" required>
            </div>
            <div class="form-group">
                <label for="duration">المدة</label>
                <input type="text" name="duration" id="duration" value="{{ old('duration', $prescription->duration) }}" required>
            </div>
            <div class="form-group">
                <label for="instructions">تعليمات إضافية</label>
                <textarea name="instructions" id="instructions" rows="2">{{ old('instructions', $prescription->instructions) }}</textarea>
            </div>
            <button type="submit" class="btn">حفظ التعديلات</button>
        </form>
    </div>
@endsection
