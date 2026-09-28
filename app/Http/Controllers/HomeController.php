<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * الصفحة الرئيسية — متاحة لأي زائر، مسجل أو مش مسجل.
     * بتعرض الأقسام والخدمات والأطباء وإحصائيات العيادة.
     */
    public function index()
    {
        $departments = Department::where('is_active', true)
            ->withCount([
                'doctors' => fn ($q) => $q->where('is_active', true),
                'services' => fn ($q) => $q->where('is_active', true),
            ])
            ->orderBy('id')
            ->get();

        $services = Service::with('department')->where('is_active', true)->orderBy('department_id')->orderBy('name')->take(9)->get();
        $doctors = Doctor::with(['user', 'department'])->where('is_active', true)->take(8)->get();

        $stats = [
            'departments' => $departments->count(),
            'doctors' => Doctor::where('is_active', true)->count(),
            'services' => Service::where('is_active', true)->count(),
        ];

        return view('welcome', compact('departments', 'services', 'doctors', 'stats'));
    }
}
