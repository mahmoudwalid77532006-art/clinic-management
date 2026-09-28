@extends('layouts.app')
@section('title', 'الزيارات')

@section('content')
    <div class="top-actions">
        <h1>الزيارات</h1>
        <a href="{{ route('visit.create') }}" class="btn">+ تسجيل زيارة</a>
    </div>

    <div class="card">
        @if ($visits->isEmpty())
            <p class="empty-state">مفيش زيارات مسجلة.</p>
        @else
            <table>
                <thead>
                    <tr><th>المريض</th><th>الطبيب</th><th>التشخيص</th><th>إجراءات</th></tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr>
                            <td>{{ $visit->patient->full_name }}</td>
                            <td>{{ $visit->doctor->user->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($visit->diagnosis, 40) ?: '—' }}</td>
                            <td class="actions">
                                <a href="{{ route('visit.show', $visit) }}" class="btn btn-sm btn-muted">عرض</a>
                                <a href="{{ route('visit.edit', $visit) }}" class="btn btn-sm">تعديل</a>
                                <form action="{{ route('visit.destroy', $visit) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
