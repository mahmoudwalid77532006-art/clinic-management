@extends('layouts.app')
@section('title', 'حجز موعد')

@section('content')
    <h1>حجز موعد جديد</h1>

    <div class="card" style="max-width:560px;">
        <form action="{{ route('appointment.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="doctor_id">الطبيب</label>
                <select name="doctor_id" id="doctor_id" required>
                    <option value="">-- اختر الطبيب --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->name }} — {{ $doctor->specialty }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="service_id">الخدمة</label>
                <select name="service_id" id="service_id" required>
                    <option value="">-- اختر الخدمة --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }} ({{ $service->price }} ج.م)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="appointment_date">التاريخ</label>
                <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" required>
            </div>

            <div class="form-group">
                <label for="start_time">من الساعة</label>
                <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
            </div>

            <div class="form-group">
                <label for="end_time">لحد الساعة</label>
                <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
            </div>

            <button type="submit" class="btn">تأكيد الحجز</button>
        </form>
    </div>
@endsection
