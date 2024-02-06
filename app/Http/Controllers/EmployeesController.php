<?php

namespace App\Http\Controllers;

use App\Models\Vitals;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\StoreEmployeesRequest;
use App\Http\Requests\UpdateEmployeesRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function dashboard(Request $request, $encryptedEmployeeId)
    {
        try {
            // Decrypt the employee ID
            $employee_id = Crypt::decryptString($encryptedEmployeeId);

            $authenticatedEmployee = Employees::where('employee_id', $employee_id)->first();

            // Check if the employee exists
            if (!$authenticatedEmployee) {
                return redirect()->route('index')->with('error', 'Invalid Employee ID');
            }

            // Fetch vitals and order by year
            $vitalsQuery = $authenticatedEmployee->vitals()->orderBy('year');
            // Check if a specific year is selected
            $selectedYear = $request->input('selectedYear', date('Y'));
            if ($selectedYear) {
                $vitalsQuery->where('year', $selectedYear);
            }

            $vitals = $vitalsQuery->get();

            // Check if vitals exist for the current month and year
            $existingVitals = $vitals
                ->where('month', now()->format('F'))
                ->where('year', now()->year)
                ->isNotEmpty();

            $vitalExistLastMonth = $vitals
                ->where('month', now()->subMonth()->format('F'))
                ->where('year', now()->subMonth()->year)
                ->isNotEmpty();

            // Get distinct years from all vitals
            $allYears = $authenticatedEmployee->vitals->pluck('year')->unique()->toArray();

            // Group vitals by year
            $groupedVitals = $vitals->groupBy('year');

            return view('dashboard', [
                'employee' => $authenticatedEmployee,
                'vitals' => $vitals,
                'vitalsExist' => $existingVitals,
                'years' => $allYears, // Use all years instead of $years
                'groupedVitals' => $groupedVitals,
                'selectedYear' => $selectedYear, // Add selectedYear for displaying in the view
                'encryptedEmployeeId' => $encryptedEmployeeId,
                'vitalExistLastMonth' => $vitalExistLastMonth,
            ]);
        } catch (DecryptException $e) {
            return redirect()->route('index')->with('error', 'Error decrypting Employee ID');
        }
    }


    /**
     * Display a listing of the resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Employees $employees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employees $employees)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeesRequest $request, Employees $employees)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employees $employees)
    {
        //
    }
}
