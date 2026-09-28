@extends('layouts.app')
@section('title', 'تعديل الموعد')

@section('content')
    <h1>تعديل حالة الموعد</h1>

    <div class="card" style="max-width:480px;">
        <p style="color:var(--muted);font-size:14px;">
            {{ $appointment->patient->full_name }} — {{ $appointment->service->name }} —
            {{ $appointment->appointment_date }} ({{ $appointment->start_time }})
        </p>

        <form action="{{ route('appointment.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">الحالة</label>
                <select name="status" id="status">
                    @foreach (['pending' => 'قيد الانتظار', 'confirmed' => 'مؤكد', 'completed' => 'تم', 'cancelled' => 'ملغي'] as $value => $label)
                        <option value="{{ $value }}" {{ $appointment->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cancellation_reason">سبب الإلغاء (لو الحالة "ملغي")</label>
                <input type="text" name="cancellation_reason" id="cancellation_reason" value="{{ old('cancellation_reason', $appointment->cancellation_reason) }}">
            </div>

            <button type="submit" class="btn">حفظ التعديل</button>
        </form>
    </div>
@endsection
