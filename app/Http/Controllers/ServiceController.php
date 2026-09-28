<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Department;
use App\Http\Requests\StoreServiceRequest;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('department')->get();

        return view('services.index', compact('services'));
    }

    public function create()
    {
        $this->authorizeManage();

        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('services.create', compact('departments'));
    }

    public function store(StoreServiceRequest $request)
    {
        $this->authorizeManage();

        Service::create($request->validated());

        return redirect()->route('service.index')->with('success', 'تمت إضافة الخدمة.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $this->authorizeManage();

        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('services.edit', compact('service', 'departments'));
    }

    public function update(StoreServiceRequest $request, Service $service)
    {
        $this->authorizeManage();

        $service->update($request->validated());

        return redirect()->route('service.index')->with('success', 'تم تحديث الخدمة.');
    }

    public function destroy(Service $service)
    {
        $this->authorizeManage();

        $service->delete();

        return redirect()->route('service.index')->with('success', 'تم حذف الخدمة.');
    }

    /**
     * Only admin and doctor accounts may create/edit/delete services.
     */
    private function authorizeManage(): void
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'doctor']), 403, 'مش مسموحلك تعدّل الخدمات.');
    }
}
