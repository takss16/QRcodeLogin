<?php

namespace App\Http\Controllers;

use App\Models\Vitals;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Auth\Authenticatable;

class LoginController extends Controller
{
    public function login($employee_id)
    {
        $employee = Employees::where('employee_id', $employee_id)->first();

        if ($employee) {
            Auth::loginUsingId(1, $remember = true);
            $authenticatedEmployee = Employees::where('employee_id', $employee_id)->first();
            $existingVitals = $authenticatedEmployee->vitals()
                ->where('month', now()->format('F'))
                ->where('year', now()->year)
                ->exists();

            $vitalsExist = $existingVitals; // Set to true if vitals exist, false otherwise
            $vitals = $authenticatedEmployee->vitals;
            return view('dashboard', ['employee' => $authenticatedEmployee, 'vitals' => $vitals, 'vitalsExist' => $vitalsExist]);
        } else {
            return redirect()->route('index')->with('error', 'Invalid Employee ID');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }

}
