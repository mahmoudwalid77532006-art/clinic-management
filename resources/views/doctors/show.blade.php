@extends('layouts.app')
@section('title', 'تفاصيل الطبيب')

@section('content')
    <h1>{{ $doctor->user->name }}</h1>
    <div class="card" style="max-width:520px;">
        <table>
            <tr><th>التخصص</th><td>{{ $doctor->specialty }}</td></tr>
            <tr><th>البريد الإلكتروني</th><td>{{ $doctor->user->email }}</td></tr>
            <tr><th>نبذة</th><td>{{ $doctor->bio ?: '—' }}</td></tr>
            <tr><th>الحالة</th><td>{{ $doctor->is_active ? 'نشط' : 'غير نشط' }}</td></tr>
        </table>
        <div style="margin-top:16px;">
            <a href="{{ route('doctor.index') }}" class="btn btn-muted">رجوع</a>
        </div>
    </div>
@endsection
