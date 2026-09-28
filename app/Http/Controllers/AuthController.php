<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\DoctorDemoDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route($this->homeRouteFor(Auth::user()->role));
        }

        return back()->withErrors([
            'email' => 'البيانات المدخلة غير صحيحة.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request, DoctorDemoDataService $demoData)
    {
        $data = $request->validate([
            'account_type' => ['required', 'in:patient,doctor'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],

            // patient fields
            'phone' => ['required_if:account_type,patient', 'nullable', 'string', 'max:255'],
            'date_of_birth' => ['required_if:account_type,patient', 'nullable', 'date'],
            'address' => ['required_if:account_type,patient', 'nullable', 'string'],
            'gender' => ['required_if:account_type,patient', 'nullable', 'in:male,female'],

            // doctor fields
            'specialty' => ['required_if:account_type,doctor', 'nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['account_type'],
        ]);

        if ($data['account_type'] === 'doctor') {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                // نربط الدكتور بالقسم لو التخصص مطابق لاسم قسم موجود
                'department_id' => \App\Models\Department::where('name', $data['specialty'])->value('id'),
                'specialty' => $data['specialty'],
                'bio' => $data['bio'] ?? null,
            ]);

            // نولّد له مواعيد وزيارات وروشتات تجريبية فورًا عشان لوحة تحكمه
            // متبقاش فاضية من أول لحظة يسجل فيها كدكتور جديد.
            $demoData->generateFor($doctor);
        } else {
            Patient::create([
                'user_id' => $user->id,
                'full_name' => $data['name'],
                'phone' => $data['phone'],
                'date_of_birth' => $data['date_of_birth'],
                'address' => $data['address'],
                'gender' => $data['gender'],
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($this->homeRouteFor($user->role));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Every role lands on the appointments page — it is scoped per role
     * (patient sees their own bookings, doctor sees their schedule,
     * admin sees everything), so it works as a role-aware dashboard.
     */
    private function homeRouteFor(string $role): string
    {
        return 'appointment.index';
    }
}
