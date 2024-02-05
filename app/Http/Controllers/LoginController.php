<?php

namespace App\Http\Controllers;

use App\Models\Vitals;
use App\Models\Employees;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Encryption\DecryptException;

class LoginController extends Controller
{

    public function login($employee_id)
    {
    $decrypted = Crypt::decryptString($employee_id);
    try {

        $employee = Employees::where('employee_id', $decrypted)->first();
        if ($employee) {
            Auth::loginUsingId(1, $remember = true);
            return redirect()->route('dashboard', $employee->employee_id);
        } else {
            return redirect()->route('index')->with('error', 'Invalid Employee ID');
        }
    } catch (DecryptException $e) {
        return redirect()->route('index')->with('error', 'Error decrypting Employee ID');
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
