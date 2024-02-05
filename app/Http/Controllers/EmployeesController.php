<?php

namespace App\Http\Controllers;

use App\Models\Vitals;
use App\Models\Employees;
use App\Http\Requests\StoreEmployeesRequest;
use App\Http\Requests\UpdateEmployeesRequest;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function dashboard($employee_id)
    {

        $authenticatedEmployee = Employees::where('employee_id', $employee_id)->first();
                $existingVitals = $authenticatedEmployee->vitals()
                    ->where('month', now()->format('F'))
                    ->where('year', now()->year)
                    ->exists();
                $years = Vitals::distinct()->pluck('year')->toArray();
                $vitalsExist = $existingVitals;
                $vitals = $authenticatedEmployee->vitals;
                 // Group vitals by year
                 $groupedVitals = $vitals->groupBy('year');

                return view('dashboard', ['employee' => $authenticatedEmployee, 'vitals' => $vitals, 'vitalsExist' => $vitalsExist, 'years' => $years, $groupedVitals]);
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
