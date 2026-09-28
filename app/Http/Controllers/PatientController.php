<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        $data = $request->validated();

        Patient::create($data);

        return redirect()->route('patient.index');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(StorePatientRequest $request, Patient $patient)
    {
        $data = $request->validated();

        $patient->update($data);

        return redirect()->route('patient.index');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patient.index');
    }
}