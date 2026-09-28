@extends('layouts.app')
@section('title', 'تفاصيل الخدمة')

@section('content')
    <h1>{{ $service->name }}</h1>
    <div class="card" style="max-width:520px;">
        <table>
            <tr><th>الوصف</th><td>{{ $service->description }}</td></tr>
            <tr><th>السعر</th><td>{{ $service->price }} ج.م</td></tr>
            <tr><th>المدة</th><td>{{ $service->duration_minutes }} دقيقة</td></tr>
            <tr><th>الحالة</th><td>{{ $service->is_active ? 'مفعّلة' : 'موقوفة' }}</td></tr>
        </table>
        <div style="margin-top:16px;">
            <a href="{{ route('service.index') }}" class="btn btn-muted">رجوع</a>
        </div>
    </div>
@endsection
