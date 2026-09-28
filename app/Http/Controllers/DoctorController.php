<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Department;
use App\Http\Requests\StoreDoctorRequest;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with(['user', 'department'])->get();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $departments = Department::where('is_active', true)->orderBy('name')->get();

            return view('doctors.create', compact('departments'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request )
    {
        $data = $request->validated();
        Doctor::create($data);
        return redirect()->route('doctor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctors.show', compact('doctor'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $departments = Department::where('is_active', true)->orderBy('name')->get();

        return view('doctors.edit', compact('doctor', 'departments'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();
        $doctor->update($data);
        return redirect()->route('doctor.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctor.index');
    }
}
