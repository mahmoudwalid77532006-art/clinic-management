@extends('layouts.app')
@section('title', 'تعديل المريض')

@section('content')
    <h1>تعديل بيانات {{ $patient->full_name }}</h1>
    <div class="card" style="max-width:520px;">
        <form action="{{ route('patient.update', $patient) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="user_id" value="{{ $patient->user_id }}">
            <div class="form-group">
                <label for="full_name">الاسم بالكامل</label>
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $patient->full_name) }}" required>
            </div>
            <div class="form-group">
                <label for="phone">الهاتف</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">تاريخ الميلاد</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
            </div>
            <div class="form-group">
                <label for="address">العنوان</label>
                <input type="text" name="address" id="address" value="{{ old('address', $patient->address) }}">
            </div>
            <div class="form-group">
                <label for="gender">النوع</label>
                <select name="gender" id="gender">
                    <option value="male" {{ $patient->gender === 'male' ? 'selected' : '' }}>ذكر</option>
                    <option value="female" {{ $patient->gender === 'female' ? 'selected' : '' }}>أنثى</option>
                </select>
            </div>
            <button type="submit" class="btn">حفظ التعديلات</button>
        </form>
    </div>
@endsection
