@extends('layouts.app')
@section('title', 'تسجيل زيارة')

@section('content')
    <h1>تسجيل زيارة جديدة</h1>
    <div class="card" style="max-width:560px;">
        @if ($appointments->isEmpty())
            <p class="empty-state">مفيش مواعيد "منتهية" لسه ملهاش زيارة مسجلة.</p>
        @else
            <form action="{{ route('visit.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="appointment_id">الموعد</label>
                    <select name="appointment_id" id="appointment_id" required onchange="
                        const opt = this.options[this.selectedIndex];
                        document.getElementById('patient_id').value = opt.dataset.patient;
                        document.getElementById('doctor_id').value = opt.dataset.doctor;">
                        <option value="">-- اختر الموعد --</option>
                        @foreach ($appointments as $appointment)
                            <option value="{{ $appointment->id }}" data-patient="{{ $appointment->patient_id }}" data-doctor="{{ $appointment->doctor_id }}">
                                {{ $appointment->patient->full_name }} — {{ $appointment->doctor->user->name }} — {{ $appointment->appointment_date }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="patient_id" id="patient_id">
                <input type="hidden" name="doctor_id" id="doctor_id">

                <div class="form-group">
                    <label for="diagnosis">التشخيص</label>
                    <textarea name="diagnosis" id="diagnosis" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="notes">ملاحظات</label>
                    <textarea name="notes" id="notes" rows="3"></textarea>
                </div>
                <button type="submit" class="btn">حفظ الزيارة</button>
            </form>
        @endif
    </div>
@endsection
