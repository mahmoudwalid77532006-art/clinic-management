@extends('layouts.app')
@section('title', 'الروشتات')

@section('content')
    <div class="top-actions">
        <h1>الروشتات</h1>
        <a href="{{ route('prescription.create') }}" class="btn">+ إضافة روشتة</a>
    </div>

    <div class="card">
        @if ($prescriptions->isEmpty())
            <p class="empty-state">مفيش روشتات مسجلة.</p>
        @else
            <table>
                <thead>
                    <tr><th>المريض</th><th>الدواء</th><th>الجرعة</th><th>إجراءات</th></tr>
                </thead>
                <tbody>
                    @foreach ($prescriptions as $prescription)
                        <tr>
                            <td>{{ $prescription->visit->patient->full_name }}</td>
                            <td>{{ $prescription->medication_name }}</td>
                            <td>{{ $prescription->dosage }} — {{ $prescription->frequency }}</td>
                            <td class="actions">
                                <a href="{{ route('prescription.show', $prescription) }}" class="btn btn-sm btn-muted">عرض</a>
                                <a href="{{ route('prescription.edit', $prescription) }}" class="btn btn-sm">تعديل</a>
                                <form action="{{ route('prescription.destroy', $prescription) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟');">
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
