@extends('layouts.app')
@section('title', 'تفاصيل الزيارة')

@section('content')
    <h1>زيارة {{ $visit->patient->full_name }}</h1>
    <div class="card" style="max-width:560px;">
        <table>
            <tr><th>الطبيب</th><td>{{ $visit->doctor->user->name }}</td></tr>
            <tr><th>التشخيص</th><td>{{ $visit->diagnosis ?: '—' }}</td></tr>
            <tr><th>ملاحظات</th><td>{{ $visit->notes ?: '—' }}</td></tr>
        </table>

        <h2 style="font-size:16px;margin-top:20px;">الروشتات</h2>
        @if ($visit->prescriptions->isEmpty())
            <p class="empty-state">مفيش روشتات لسه.</p>
        @else
            <ul>
                @foreach ($visit->prescriptions as $p)
                    <li>{{ $p->medication_name }} — {{ $p->dosage }} — {{ $p->frequency }}</li>
                @endforeach
            </ul>
        @endif
        <a href="{{ route('prescription.create') }}" class="btn btn-sm">+ إضافة روشتة لهذه الزيارة</a>

        <div style="margin-top:16px;">
            <a href="{{ route('visit.index') }}" class="btn btn-muted">رجوع</a>
        </div>
    </div>
@endsection
