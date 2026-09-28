@extends('layouts.app')
@section('title', 'المستخدمين')

@section('content')
    <div class="top-actions">
        <h1>المستخدمين</h1>
        <a href="{{ route('user.create') }}" class="btn">+ إضافة مستخدم</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr><th>الاسم</th><th>البريد الإلكتروني</th><th>الدور</th><th>إجراءات</th></tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ['admin' => 'مدير', 'doctor' => 'دكتور', 'receptionist' => 'استقبال', 'patient' => 'مريض'][$user->role] ?? $user->role }}</td>
                        <td class="actions">
                            <a href="{{ route('user.show', $user) }}" class="btn btn-sm btn-muted">عرض</a>
                            <a href="{{ route('user.edit', $user) }}" class="btn btn-sm">تعديل</a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('user.destroy', $user) }}" method="POST" onsubmit="return confirm('متأكد من الحذف؟');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
