@extends('layouts.app')
@section('title', 'الأقسام')

@section('content')
    @php($canManage = auth()->user()->role === 'admin')
    <div class="top-actions">
        <h1>الأقسام الطبية</h1>
        @if ($canManage)
            <a href="{{ route('department.create') }}" class="btn">+ إضافة قسم</a>
        @endif
    </div>

    @if ($departments->isEmpty())
        <div class="card"><p class="empty-state">مفيش أقسام مضافة لسه.</p></div>
    @else
        <div class="grid-cards">
            @foreach ($departments as $department)
                <div class="card dept-card">
                    <div class="dept-icon">{{ $department->icon ?: '🏥' }}</div>
                    <h3>{{ $department->name }}</h3>
                    <p class="muted">{{ \Illuminate\Support\Str::limit($department->description, 70) ?: 'قسم طبي متكامل.' }}</p>
                    <div class="dept-meta">
                        <span>{{ $department->doctors_count }} دكتور</span>
                        <span>{{ $department->services_count }} خدمة</span>
                    </div>
                    <div class="actions" style="margin-top:12px;">
                        <a href="{{ route('department.show', $department) }}" class="btn btn-sm btn-muted">عرض</a>
                        @if ($canManage)
                            <a href="{{ route('department.edit', $department) }}" class="btn btn-sm">تعديل</a>
                            <form action="{{ route('department.destroy', $department) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
