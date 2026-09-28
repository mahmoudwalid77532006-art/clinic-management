@extends('layouts.app')
@section('title', 'تعديل الزيارة')

@section('content')
    <h1>تعديل زيارة {{ $visit->patient->full_name }}</h1>
    <div class="card" style="max-width:560px;">
        <form action="{{ route('visit.update', $visit) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="appointment_id" value="{{ $visit->appointment_id }}">
            <input type="hidden" name="patient_id" value="{{ $visit->patient_id }}">
            <input type="hidden" name="doctor_id" value="{{ $visit->doctor_id }}">
            <div class="form-group">
                <label for="diagnosis">التشخيص</label>
                <textarea name="diagnosis" id="diagnosis" rows="3">{{ old('diagnosis', $visit->diagnosis) }}</textarea>
            </div>
            <div class="form-group">
                <label for="notes">ملاحظات</label>
                <textarea name="notes" id="notes" rows="3">{{ old('notes', $visit->notes) }}</textarea>
            </div>
            <button type="submit" class="btn">حفظ التعديلات</button>
        </form>
    </div>
@endsection
