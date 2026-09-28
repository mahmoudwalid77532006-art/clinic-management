<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount(['doctors', 'services'])->orderBy('name')->get();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $this->authorizeManage();

        return view('departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        $this->authorizeManage();

        try {
            DB::transaction(function () use ($request) {
                Department::create($request->validated());
            });
        } catch (\Throwable $e) {
            Log::error('فشل إضافة القسم: '.$e->getMessage());

            return back()->withInput()->with('error', 'حصل خطأ أثناء إضافة القسم، حاول تاني.');
        }

        return redirect()->route('department.index')->with('success', 'تمت إضافة القسم.');
    }

    public function show(Department $department)
    {
        $department->load(['doctors.user', 'services']);

        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $this->authorizeManage();

        return view('departments.edit', compact('department'));
    }

    public function update(StoreDepartmentRequest $request, Department $department)
    {
        $this->authorizeManage();

        try {
            DB::transaction(function () use ($request, $department) {
                $department->update($request->validated());
            });
        } catch (\Throwable $e) {
            Log::error('فشل تحديث القسم: '.$e->getMessage());

            return back()->withInput()->with('error', 'حصل خطأ أثناء تحديث القسم، حاول تاني.');
        }

        return redirect()->route('department.index')->with('success', 'تم تحديث القسم.');
    }

    public function destroy(Department $department)
    {
        $this->authorizeManage();

        $department->delete();

        return redirect()->route('department.index')->with('success', 'تم حذف القسم.');
    }

    /**
     * إدارة الأقسام (إضافة/تعديل/حذف) لل Admin بس، أما العرض فمتاح لأي حد مسجل دخول.
     */
    private function authorizeManage(): void
    {
        abort_unless(auth()->user()->role === 'admin', 403, 'مش مسموحلك تعدّل الأقسام.');
    }
}
