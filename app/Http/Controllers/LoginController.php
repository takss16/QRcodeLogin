<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class LoginController extends Controller
{

    public function login($employee_id)
    {

        try {
            $decrypted = Crypt::decryptString($employee_id);
            $employee = Employees::where('employee_id', $decrypted)->first();

            if ($employee) {
                // Encrypt the employee ID again
                $encryptedEmployeeId = Crypt::encryptString($employee->employee_id);

                Auth::loginUsingId(1, $remember = true);

                return redirect()->route('dashboard', $encryptedEmployeeId);
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

        $request->session()->flush();

        return redirect()->route('index');
    }

}
