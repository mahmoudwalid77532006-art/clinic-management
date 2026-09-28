@extends('layouts.app')
@section('title', 'تفاصيل الروشتة')

@section('content')
    <h1>{{ $prescription->medication_name }}</h1>
    <div class="card" style="max-width:520px;">
        <table>
            <tr><th>المريض</th><td>{{ $prescription->visit->patient->full_name }}</td></tr>
            <tr><th>الطبيب</th><td>{{ $prescription->visit->doctor->user->name }}</td></tr>
            <tr><th>الجرعة</th><td>{{ $prescription->dosage }}</td></tr>
            <tr><th>عدد المرات</th><td>{{ $prescription->frequency }}</td></tr>
            <tr><th>المدة</th><td>{{ $prescription->duration }}</td></tr>
            <tr><th>تعليمات</th><td>{{ $prescription->instructions ?: '—' }}</td></tr>
        </table>
        <div style="margin-top:16px;">
            <a href="{{ route('prescription.index') }}" class="btn btn-muted">رجوع</a>
        </div>
    </div>
@endsection
