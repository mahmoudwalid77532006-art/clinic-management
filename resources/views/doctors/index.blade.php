@extends('layouts.app')
@section('title', 'الأطباء')

@section('content')
    @php($role = auth()->user()->role)
    <div class="top-actions">
        <h1>الأطباء</h1>
        @if ($role === 'admin')
            <a href="{{ route('doctor.create') }}" class="btn">+ إضافة طبيب</a>
        @endif
    </div>

    <div class="card">
        @if ($doctors->isEmpty())
            <p class="empty-state">مفيش أطباء مسجلين.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>الاسم</th><th>القسم</th><th>التخصص</th><th>الحالة</th><th>مدة الكشف</th><th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->user->name }}</td>
                            <td>{{ $doctor->department?->name ?? '—' }}</td>
                            <td>{{ $doctor->specialty }}</td>
                            <td>{{ $doctor->is_active ? 'نشط' : 'غير نشط' }}</td>
                            <td>{{ $doctor->slot_duration_minutes }} دقيقة</td>
                            <td class="actions">
                                <a href="{{ route('doctor.show', $doctor) }}" class="btn btn-sm btn-muted">عرض</a>
                                @if ($role === 'admin')
                                    <a href="{{ route('doctor.edit', $doctor) }}" class="btn btn-sm">تعديل</a>
                                    <form action="{{ route('doctor.destroy', $doctor) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟');">
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
