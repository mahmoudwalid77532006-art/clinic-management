@extends('layouts.app')
@section('title', $department->name)

@section('content')
    <div class="top-actions">
        <h1>{{ $department->icon ?? '🏥' }} {{ $department->name }}</h1>
        <a href="{{ route('department.index') }}" class="btn btn-muted">رجوع للأقسام</a>
    </div>

    <div class="card">
        <p class="muted">{{ $department->description ?: 'مفيش وصف مضاف لسه.' }}</p>
    </div>

    <div class="card">
        <h3>الأطباء في القسم ده</h3>
        @if ($department->doctors->isEmpty())
            <p class="empty-state">مفيش أطباء مربوطين بالقسم ده لسه.</p>
        @else
            <table>
                <thead><tr><th>الاسم</th><th>التخصص</th><th>الحالة</th></tr></thead>
                <tbody>
                    @foreach ($department->doctors as $doctor)
                        <tr>
                            <td><a href="{{ route('doctor.show', $doctor) }}">{{ $doctor->user->name }}</a></td>
                            <td>{{ $doctor->specialty }}</td>
                            <td>{{ $doctor->is_active ? 'نشط' : 'غير نشط' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="card">
        <h3>خدمات القسم</h3>
        @if ($department->services->isEmpty())
            <p class="empty-state">مفيش خدمات مربوطة بالقسم ده لسه.</p>
        @else
            <table>
                <thead><tr><th>الاسم</th><th>السعر</th><th>المدة</th></tr></thead>
                <tbody>
                    @foreach ($department->services as $service)
                        <tr>
                            <td><a href="{{ route('service.show', $service) }}">{{ $service->name }}</a></td>
                            <td>{{ $service->price }} ج.م</td>
                            <td>{{ $service->duration_minutes }} دقيقة</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
