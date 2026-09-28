@extends('layouts.app')
@section('title', 'تفاصيل الموعد')

@section('content')
    <h1>تفاصيل الموعد</h1>

    <div class="card" style="max-width:520px;">
        <table>
            <tr><th>المريض</th><td>{{ $appointment->patient->full_name }}</td></tr>
            <tr><th>الطبيب</th><td>{{ $appointment->doctor->user->name }} ({{ $appointment->doctor->specialty }})</td></tr>
            <tr><th>الخدمة</th><td>{{ $appointment->service->name }}</td></tr>
            <tr><th>التاريخ</th><td>{{ $appointment->appointment_date }}</td></tr>
            <tr><th>الوقت</th><td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td></tr>
            <tr><th>السعر</th><td>{{ $appointment->price }} ج.م</td></tr>
            <tr><th>الحالة</th><td><span class="badge badge-{{ $appointment->status }}">
                {{ ['pending' => 'قيد الانتظار', 'confirmed' => 'مؤكد', 'completed' => 'تم', 'cancelled' => 'ملغي'][$appointment->status] }}
            </span></td></tr>
            @if ($appointment->cancellation_reason)
                <tr><th>سبب الإلغاء</th><td>{{ $appointment->cancellation_reason }}</td></tr>
            @endif
        </table>

        <div style="margin-top:16px;">
            <a href="{{ route('appointment.index') }}" class="btn btn-muted">رجوع</a>
        </div>
    </div>
@endsection
