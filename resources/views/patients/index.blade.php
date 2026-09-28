@extends('layouts.app')
@section('title', 'المرضى')

@section('content')
    <div class="top-actions">
        <h1>المرضى</h1>
        <a href="{{ route('patient.create') }}" class="btn">+ إضافة مريض</a>
    </div>

    <div class="card">
        @if ($patients->isEmpty())
            <p class="empty-state">مفيش مرضى مسجلين.</p>
        @else
            <table>
                <thead>
                    <tr><th>الاسم</th><th>الهاتف</th><th>تاريخ الميلاد</th><th>العنوان</th><th>إجراءات</th></tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->full_name }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->date_of_birth }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($patient->address, 30) }}</td>
                            <td class="actions">
                                <a href="{{ route('patient.show', $patient) }}" class="btn btn-sm btn-muted">عرض</a>
                                <a href="{{ route('patient.edit', $patient) }}" class="btn btn-sm">تعديل</a>
                                <form action="{{ route('patient.destroy', $patient) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟');">
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
