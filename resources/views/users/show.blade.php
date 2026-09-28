@extends('layouts.app')
@section('title', 'تفاصيل المستخدم')

@section('content')
    <h1>{{ $user->name }}</h1>
    <div class="card" style="max-width:480px;">
        <table>
            <tr><th>البريد الإلكتروني</th><td>{{ $user->email }}</td></tr>
            <tr><th>الدور</th><td>{{ $user->role }}</td></tr>
        </table>
        <div style="margin-top:16px;">
            <a href="{{ route('user.index') }}" class="btn btn-muted">رجوع</a>
        </div>
    </div>
@endsection
