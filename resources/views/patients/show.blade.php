@extends('layouts.app')
@section('title', 'تفاصيل المريض')

@section('content')
    <h1>{{ $patient->full_name }}</h1>
    <div class="card" style="max-width:520px;">
        <table>
            <tr><th>الهاتف</th><td>{{ $patient->phone }}</td></tr>
            <tr><th>تاريخ الميلاد</th><td>{{ $patient->date_of_birth }}</td></tr>
            <tr><th>العنوان</th><td>{{ $patient->address }}</td></tr>
            <tr><th>النوع</th><td>{{ $patient->gender === 'male' ? 'ذكر' : 'أنثى' }}</td></tr>
        </table>
        <div style="margin-top:16px;">
            <a href="{{ route('patient.index') }}" class="btn btn-muted">رجوع</a>
        </div>
    </div>
@endsection
