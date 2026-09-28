@extends('layouts.app')
@section('title', 'المواعيد')

@section('content')
    @php($role = auth()->user()->role)

    <div class="top-actions">
        <h1>{{ $role === 'patient' ? 'مواعيدي' : ($role === 'doctor' ? 'مواعيدي كطبيب' : 'كل المواعيد') }}</h1>
        @if ($role === 'patient')
            <a href="{{ route('appointment.create') }}" class="btn">+ حجز موعد جديد</a>
        @endif
    </div>

    <div class="card">
        @if ($appointments->isEmpty())
            <p class="empty-state">مفيش مواعيد لسه.</p>
        @else
            <table>
                <thead>
                    <tr>
                        @if ($role !== 'patient')
                            <th>المريض</th>
                        @endif
                        @if ($role !== 'doctor')
                            <th>الطبيب</th>
                        @endif
                        <th>الخدمة</th>
                        <th>التاريخ</th>
                        <th>الوقت</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            @if ($role !== 'patient')
                                <td>{{ $appointment->patient->full_name }}</td>
                            @endif
                            @if ($role !== 'doctor')
                                <td>{{ $appointment->doctor->user->name }}</td>
                            @endif
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                            <td>{{ $appointment->price }} ج.م</td>
                            <td><span class="badge badge-{{ $appointment->status }}">
                                {{ ['pending' => 'قيد الانتظار', 'confirmed' => 'مؤكد', 'completed' => 'تم', 'cancelled' => 'ملغي'][$appointment->status] }}
                            </span></td>
                            <td class="actions">
                                <a href="{{ route('appointment.show', $appointment) }}" class="btn btn-sm btn-muted">عرض</a>
                                @if (in_array($role, ['doctor', 'admin']))
                                    <a href="{{ route('appointment.edit', $appointment) }}" class="btn btn-sm">تعديل</a>
                                    <form action="{{ route('appointment.destroy', $appointment) }}" method="POST"
                                          onsubmit="return confirm('متأكد من حذف الموعد؟');">
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
