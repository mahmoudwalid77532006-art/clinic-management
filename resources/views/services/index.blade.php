@extends('layouts.app')
@section('title', 'الخدمات')

@section('content')
    @php($canManage = in_array(auth()->user()->role, ['admin', 'doctor']))
    <div class="top-actions">
        <h1>الخدمات</h1>
        @if ($canManage)
            <a href="{{ route('service.create') }}" class="btn">+ إضافة خدمة</a>
        @endif
    </div>

    <div class="card">
        @if ($services->isEmpty())
            <p class="empty-state">مفيش خدمات مضافة.</p>
        @else
            <table>
                <thead>
                    <tr><th>الاسم</th><th>القسم</th><th>الوصف</th><th>السعر</th><th>المدة</th><th>الحالة</th><th>إجراءات</th></tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->department?->name ?? '—' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($service->description, 40) }}</td>
                            <td>{{ $service->price }} ج.م</td>
                            <td>{{ $service->duration_minutes }} دقيقة</td>
                            <td>{{ $service->is_active ? 'مفعّلة' : 'موقوفة' }}</td>
                            <td class="actions">
                                <a href="{{ route('service.show', $service) }}" class="btn btn-sm btn-muted">عرض</a>
                                @if ($canManage)
                                    <a href="{{ route('service.edit', $service) }}" class="btn btn-sm">تعديل</a>
                                    <form action="{{ route('service.destroy', $service) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
